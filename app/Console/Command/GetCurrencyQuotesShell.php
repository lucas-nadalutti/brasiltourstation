<?php

class GetCurrencyQuotesShell extends AppShell {

    public $uses = array('CurrencyQuote');
    public $tasks = array('WebQuery');

	public function main() {
    	$this->stdout->styles('green', array('text' => 'green'));
    	$this->stdout->styles('red', array('text' => 'red'));

		$quotes = $this->WebQuery->execute();
		$currentDate = date('Y-m-d');
		$existingQuotes = $this->CurrencyQuote->findByQuoteDate($currentDate);
		if ($existingQuotes) {
			$this->CurrencyQuote->id = $existingQuotes['CurrencyQuote']['id'];
		}
		$currencyQuotesObj = array(
			'CurrencyQuote' => array(
				'quote_date' => $currentDate,
				'dollar' => $quotes['dollar']['sale'],
				'dollar_variation' => $quotes['dollar']['variation'],
				'euro' => $quotes['euro']['sale'],
				'euro_variation' => $quotes['euro']['variation'],
				'pound' => $quotes['pound']['sale'],
				'pound_variation' => $quotes['pound']['variation'],
			)
		);
		if ($this->CurrencyQuote->save($currencyQuotesObj)) {
			$this->out('<green>Cotações de '.$currentDate.' carregadas com sucesso!</green>');
		}
		else {
			$this->out('<red>Ocorreu um erro ao tentar salvar as cotações de '.$currentDate.'.</red>');
		}
	}

}