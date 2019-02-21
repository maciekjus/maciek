<?php

namespace App\Service;


class Offer
{
	private $templateName = 'addons/offer/list.html.twig';
	private $itemsList = array();

	public function getTeplateName()
	{
		return $this->templateName;
	}

	public function setTeplateName($name)
	{
		$this->templateName = $name;
	}

	public function getData()
	{

	//--------------------------------------------------------------------------
		$this->itemsList[1]['image'] = 0;
		$this->itemsList[1]['title'] = 'modal1';
		$this->itemsList[1]['content'] = '';
	//--------------------------------------------------------------------------
		$this->itemsList[6]['image'] = 7;
		$this->itemsList[6]['title'] = 'Farbi i tynki';
		$this->itemsList[6]['content'] = 'Dzięki mieszalnikowi firmy FAST przygotujemy dla Państwa tynki i farby w dowolnym kolorze spośród szerokiego wachlarza barw. W naszej ofercie m. in.: <br>- farby akrylowe, lateksowe, wewnętrzne, elewacyjne<br>- tynki akrylowe i mozaikowe';
	//--------------------------------------------------------------------------
		$this->itemsList[8]['image'] = 8;
		$this->itemsList[8]['title'] = 'Impregnaty, bejce i lakiery';
		$this->itemsList[8]['content'] = 'Materiały do ochrony i dekoracji drewna.';
	//--------------------------------------------------------------------------
		$this->itemsList[10]['image'] = 1;
		$this->itemsList[10]['title'] = 'System wentylacji';
		$this->itemsList[10]['content'] = 'Przewody wentylacyjne, kratki, wentylatory.';
		$this->itemsList[10]['modal_content'] = '';
	//--------------------------------------------------------------------------
		$this->itemsList[20]['image'] = 2;
		$this->itemsList[20]['title'] = 'Artykuły elektryczne';
		$this->itemsList[20]['content'] = 'Przewody, gniazda, przełączniki, żarówki.';
		$this->itemsList[20]['modal_content'] = '';
	//--------------------------------------------------------------------------
		$this->itemsList[30]['image'] = 3;
		$this->itemsList[30]['title'] = 'Narzędzia';
		$this->itemsList[30]['content'] = 'Narzędzie ręczne i elektronarzędzia.';
		$this->itemsList[30]['modal_content'] = '';
	//--------------------------------------------------------------------------
		$this->itemsList[40]['image'] = 4;
		$this->itemsList[40]['title'] = 'Drewno i okucia';
		$this->itemsList[40]['content'] = 'Drewno konstrukcyjne, materiały drewnopochodne (płyty OSB, pilśniowe) i metalowe okucia.';
		$this->itemsList[40]['modal_content'] = '';
	//--------------------------------------------------------------------------
		$this->itemsList[50]['image'] = 5;
		$this->itemsList[50]['title'] = 'Taśmy';
		$this->itemsList[50]['content'] = 'Malarskie, tynkarskie, izolacyjne, ostrzegawcze, pakowe, dylatacyjne.';
	//--------------------------------------------------------------------------
		$this->itemsList[60]['image'] = 6;
		$this->itemsList[60]['title'] = 'Sznury i liny';
		$this->itemsList[60]['content'] = 'Sznurki uniwersalne, sznurki murarskie, liny, linki stalowe, szczeliwo.';
	//--------------------------------------------------------------------------
		$this->itemsList[70]['image'] = 9;
		$this->itemsList[70]['title'] = 'Chemia budowlana';
		$this->itemsList[70]['content'] = 'Grunty, rozpuszczalniki, kleje, smary, udrażniacze rur i inne.';
	//--------------------------------------------------------------------------
		$this->itemsList[80]['image'] = 10;
		$this->itemsList[80]['title'] = 'System kanalizacji';
		$this->itemsList[80]['content'] = 'Rury i kształtki kanalizacyjne od średnicy 32mm do 200mm, a także rury drenażowe i studzienki.';
	//--------------------------------------------------------------------------
		$this->itemsList[90]['image'] = 11;
		$this->itemsList[90]['title'] = 'Hydraulika';
		$this->itemsList[90]['content'] = 'W sprzedarzy posiadamy wszystkie artykuły hydrauliczne potrzebne do wykonania kompletnej instalacji.';
	//--------------------------------------------------------------------------
		$this->itemsList[95]['image'] = 16;
		$this->itemsList[95]['title'] = 'System suchej zabudowy';
		$this->itemsList[95]['content'] = 'Płyty regipsowe, stelaże, łączniki stelarzy, wieszaki, taśmy dylatacyjne, taśmy na łączenia.';
	//--------------------------------------------------------------------------
		$this->itemsList[100]['image'] = 12;
		$this->itemsList[100]['title'] = 'Cement, wapno, zaprawy, kleje budowlane';
		$this->itemsList[100]['content'] = 'Oferujemy cement, wapno, gips oraz wiele gotowych zapraw i klejów budowlanych.';
	//--------------------------------------------------------------------------
		$this->itemsList[110]['image'] = 13;
		$this->itemsList[110]['title'] = 'Izolacja termiczna';
		$this->itemsList[110]['content'] = 'Styropian, styropapa, wełna mineralna';
	//--------------------------------------------------------------------------
		$this->itemsList[120]['image'] = 14;
		$this->itemsList[120]['title'] = 'Cegły, bloczki, pustaki';
		$this->itemsList[120]['content'] = 'W ofercie posiadamy cegły tradycyjne, klinkierowe, bloczki betonowe, gazobeton, pustaki ceramiczne.';
	//--------------------------------------------------------------------------
		$this->itemsList[130]['image'] = 15;
		$this->itemsList[130]['title'] = 'Stal zbrojeniowa';
		$this->itemsList[130]['content'] = 'Posiadamy dostępne od ręki pręty zbrojeniowe gładkie i rzebrowane.';
	//--------------------------------------------------------------------------
		$this->itemsList[140]['image'] = 17;
		$this->itemsList[140]['title'] = 'Izolacje przeciwwilgociowe i przeciwwodne';
		$this->itemsList[140]['content'] = 'Folie paroizolacyjne, budowlane, kubełkowe, papy.';
	//--------------------------------------------------------------------------
		$this->itemsList[150]['image'] = 18;
		$this->itemsList[150]['title'] = 'Mocowania i łączniki';
		$this->itemsList[150]['content'] = 'Kleje montażowe, wkręty, gwoździe, śruby, kołki, kotwy, uchwyty rur kanalizacyjnych i hydraulicznych.';
	//--------------------------------------------------------------------------
		$this->itemsList[150]['image'] = 19;
		$this->itemsList[150]['title'] = 'Fugi i silikony';
		$this->itemsList[150]['content'] = 'Fugi, silinkony oraz inne materiały i narzędzie potrzebne przy montażu płytek. <i>Uwaga! Nie prowadzimy sprzedarzy płytek ceramicznych.</i>';
	//--------------------------------------------------------------------------
		$this->itemsList[155]['image'] = 0;
		$this->itemsList[155]['title'] = 'modal2';
		$this->itemsList[155]['content'] = '';
	//--------------------------------------------------------------------------
		$this->itemsList[160]['image'] = 20;
		$this->itemsList[160]['title'] = 'Transport';
		$this->itemsList[160]['content'] = 'Oferujemy dowóz zakupionych materiałów busem na wskazany adres. Rozładunek nie jest wpliczony w usługę transportu.';
	//--------------------------------------------------------------------------
		$this->itemsList[170]['image'] = 21;
		$this->itemsList[170]['title'] = 'Wynajem rusztowań';
		$this->itemsList[170]['content'] = 'Posiadamy rusztowania na wynajem.';
	//--------------------------------------------------------------------------
		$this->itemsList[180]['image'] = 22;
		$this->itemsList[180]['title'] = 'Wynajem stempli';
		$this->itemsList[180]['content'] = 'Wynajmujemy stemple budowlane stalowe.';
	//--------------------------------------------------------------------------

		return $this->itemsList;
	}



}
