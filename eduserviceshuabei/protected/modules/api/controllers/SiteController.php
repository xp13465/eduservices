<?php

class SiteController extends Controller {
	
    public $layout='frame';
    public function actionIndex() {
        $this->render('index');
    }
	
}