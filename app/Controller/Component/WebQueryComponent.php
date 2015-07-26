<?php

// XXX: Manually loading since CakePHP 2.x doesn't support namespaces
use Masterminds\HTML5;

App::uses('Component', 'Controller');

class WebQueryComponent extends Component {

    public function getCurrencyQuotes() {
        $currencyQuerier = new CurrencyQuerier();
        $quotes = $currencyQuerier->getQuotes();
        // TODO: Send an email in case of errors
        return $quotes;
    }

}

class CurrencyQuerier {

    public function getQuotes() {
        $html5 = new HTML5();
        $dom = $html5->loadHTMLFile('http://www.valor.com.br/valor-data/moedas');
        $finder = new DomXPath($dom);
        return $this->valorEconomicoQuotes($finder);
    }

    private function valorEconomicoQuotes($finder) {
        // Valor Econômico's HTML page has the following xmlns
        $finder->registerNamespace("ns", "http://www.w3.org/1999/xhtml");

        $tourismDollarTds = $finder->query(
            "//ns:tr[.//ns:td[.//ns:span[text()='Dolar Comercial']]]/ns:td"
        );
        $quotes['dollar'] = $this->fillQuotesInfo($tourismDollarTds);

        $tourismEuroTds = $finder->query(
            "//ns:tr[.//ns:td[.//ns:span[text()='Euro x Real']]]/ns:td"
        );
        $quotes['euro'] = $this->fillQuotesInfo($tourismEuroTds);

        $tourismPoundTds = $finder->query(
            "//ns:tr[.//ns:td[.//ns:span[text()='Real/Libra Britanica **']]]/ns:td"
        );
        $quotes['pound'] = $this->fillQuotesInfo($tourismPoundTds);
        return $quotes; 
    }

    private function fillQuotesInfo($tds) {
        $purchase = (float) str_replace(',', '.', $tds->item(1)->textContent);
        $sale = (float) str_replace(',', '.', $tds->item(2)->textContent);
        $variation = (float) str_replace(',', '.', $tds->item(3)->textContent);
        $latestUpdate = $tds->item(4)->textContent;

        // Stringify values
        $purchase = 'R$ ' . number_format($purchase, 2, ',', '.');
        $sale = 'R$ ' . number_format($sale, 2, ',', '.');
        $formattedVariation = number_format($variation, 2, ',', '.') . '%';
        if ($variation > 0) {
            $variation = '+' . $formattedVariation;
        }
        else {
            $variation = $formattedVariation;
        }
        $latestUpdateTimestamp = date_create_from_format('d/m - H:i', $latestUpdate)->getTimestamp();
        $latestUpdate = date('d/m - H:i', $latestUpdateTimestamp);

        return array(
            'purchase' => $purchase,
            'sale' => $sale,
            'variation' => $variation,
            'latest_update' => $latestUpdate,
        );
    }
}