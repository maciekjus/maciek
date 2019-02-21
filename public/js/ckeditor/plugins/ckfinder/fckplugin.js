/*
 * This is just a sample plugin for FCKeditor.
 * This sample plugin shows how to launch an external application and return
 * data from this application straight into FCKeditor editing area.
 *
 * To install it, open fckconfig.js and add:
 *
 *   FCKConfig.Plugins.Add( 'ckfinder' ) ;
 *
 * In the same file, in the toolbar definition (FCKConfig.ToolbarSets["ToolbarName"])
 * add a new button: 'CKFinder'.
 *
 * Clear browser's cache, and you should see another button in the Toolbar.
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU General Public License Version 2 or later (the "GPL")
 *    http://www.gnu.org/licenses/gpl.html
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 *  - Mozilla Public License Version 1.1 or later (the "MPL")
 *    http://www.mozilla.org/MPL/MPL-1.1.html
 */

// CKFinder command.
var CKFinderCommand = function()
{
  this.Name = 'CKFinder' ;
}

CKFinderCommand.prototype.Execute = function()
{
  PopupCKFinder( '/ckfinder/ckfinder.html?action=js&func=InsertFile&thumbFunc=InsertThumbnail' );
}

CKFinderCommand.prototype.GetState = function()
{
  return FCK_TRISTATE_OFF ;
}

FCKCommands.RegisterCommand( 'CKFinder', new CKFinderCommand( ) ) ;

// Create the toolbar button.
var oCKFinderItem = new FCKToolbarButton( 'CKFinder', FCKLang.InsertImageLbl, FCKLang.InsertImage, null, false, true, 37) ;

FCKToolbarItems.RegisterItem( 'CKFinder', oCKFinderItem ) ;

var RegexpFileExtension	= /[^\.]+$/ ;
var RegexpImagesExt = /^(jpg|gif|png|bmp|jpeg)$/i ;

// Called when image is selected in CKFinder.
function InsertFile( fileUrl, data )
{
  var sExt = fileUrl.match( RegexpFileExtension ) ;
  var sFileName = decodeURIComponent( fileUrl.replace( /^.*[\/\\]/g, '' ) ) ;

  if ( sExt && ( sExt = sExt[0] ) && RegexpImagesExt.test( sExt ) )
    FCK.InsertHtml( '<img src="' + fileUrl + '" />' );
  else
    FCK.InsertHtml( '<a href="' + data["fileUrl"] + '" target="_blank">' + sFileName + ' (' + data["fileSize"] + 'KB)</a>' );
}

// Called when thumbnail is selected in CKFinder.
function InsertThumbnail( fileUrl, data )
{
  FCK.InsertHtml( '<a href="' + data['fileUrl'] + '"><img src="' + data['thumbnailUrl'] + '" /></a>' );
}

// Opens CKFinder in a popup. The "width" and "height" parameters accept
// numbers (pixels) or percent (of screen size) values.
function PopupCKFinder( url, width, height )
{
  width = width || '80%' ;
  height = height || '70%' ;

  if ( typeof width == 'string' && width.length > 1 && width.substr( width.length - 1, 1 ) == '%' )
  width = parseInt( window.screen.width * parseInt( width ) / 100 ) ;

  if ( typeof height == 'string' && height.length > 1 && height.substr( height.length - 1, 1 ) == '%' )
  height = parseInt( window.screen.height * parseInt( height ) / 100 ) ;

  if ( width < 200 )
  width = 200 ;

  if ( height < 200 )
  height = 200 ;

  var top = parseInt( ( window.screen.height - height ) / 2 ) ;
  var left = parseInt( ( window.screen.width  - width ) / 2 ) ;

  var options = 'location=no,menubar=no,toolbar=no,dependent=yes,minimizable=no,modal=yes,alwaysRaised=yes,resizable=yes' +
  ',width='  + width +
  ',height=' + height +
  ',top='  + top +
  ',left=' + left ;

  var popupWindow = window.open( '', 'CKFinderPopup', options, true ) ;

  // Blocked by a popup blocker.
  if ( !popupWindow )
  return false ;

  try
  {
    popupWindow.moveTo( left, top ) ;
    popupWindow.resizeTo( width, height ) ;
    popupWindow.focus() ;
    popupWindow.location.href = this._BuildUrl() ;
  }
  catch (e)
  {
    popupWindow = window.open( url, 'CKFinderPopup', options, true ) ;
  }

  return true ;
}
