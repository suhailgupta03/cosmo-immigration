
/**
 * Currency Converter Library
 * @author suhail
 * @date Feburary 9,2016
 * @version 1.0.0
 */
var currencyMap = {};
currencyMap['United Arab Emirates Dirham']='AED';
currencyMap['Argentine Peso']='ARS';
currencyMap['Australian Dollar']='AUD';
currencyMap['Bulgarian Lev']='BGN';
currencyMap['Brunei Dollar']='BND';
currencyMap['Bolivian Boliviano']='BOB';
currencyMap['Brazilian Real']='BRL';
currencyMap['Canadian Dollar']='CAD';
currencyMap['Swiss Franc']='CHF';
currencyMap['Chilean Peso']='CLP';
currencyMap['Chinese Yuan Renminbi']='CNY';
currencyMap['Colombian Peso']='COP';
currencyMap['Czech Republic Koruna']='CZK';
currencyMap['Danish Krone']='DKK';
currencyMap['Egyptian Pound']='EGP';
currencyMap['Euro']='EUR';
currencyMap['Fijian Dollar']='FJD';
currencyMap['British Pound Sterling']='GBP';
currencyMap['Hong Kong Dollar']='HKD';
currencyMap['Croatian Kuna']='HRK';
currencyMap['Hungarian Forint']='HUF';
currencyMap['Indonesian Rupiah']='IDR';
currencyMap['Israeli New Sheqel']='ILS';
currencyMap['Indian Rupee']='INR';
currencyMap['Japanese Yen']='JPY';
currencyMap['Kenyan Shilling']='KES';
currencyMap['South Korean Won']='KRW';
currencyMap['Lithuanian Litas']='LTL';
currencyMap['Moroccan Dirham']='MAD';
currencyMap['Mexican Peso']='MXN';
currencyMap['Malaysian Ringgit']='MYR';
currencyMap['Norwegian Krone']='NOK';
currencyMap['New Zealand Dollar']='NZD';
currencyMap['Peruvian Nuevo Sol']='PEN';
currencyMap['Philippine Peso']='PHP';
currencyMap['Pakistani Rupee']='PKR';
currencyMap['Polish Zloty']='PLN';
currencyMap['Romanian Leu']='RON';
currencyMap['Serbian Dinar']='RSD';
currencyMap['Russian Ruble']='RUB';
currencyMap['Saudi Riyal']='SAR';
currencyMap['Swedish Krona']='SEK';
currencyMap['Singapore Dollar']='SGD';
currencyMap['Thai Baht']='THB';
currencyMap['Turkish Lira']='TRY';
currencyMap['New Taiwan Dollar']='TWD';
currencyMap['Ukrainian Hryvnia']='UAH';
currencyMap['US Dollar']='USD';
currencyMap['Venezuelan Bolí­var Fuerte']='VEF';
currencyMap['Vietnamese Dong']='VND';
currencyMap['South African Ran']='ZAR';

$.each(currencyMap,function(key,value){
	$('.currency-converter-sb').append('<option>' + key + ' (' + value + ') ' + '</option>');
});

$('#currency-converter-button').on('click',function(event){	
	var from = currencyMap[$('#currency-converter-from').val().split(" (")[0]];	
	var to = currencyMap[$('#currency-converter-to').val().split(" (")[0]];
	var amount = $('#currency-converter-amount').val();
	$('.currency-converter-result').removeClass('bg-info bg-warning bg-danger').empty();
	if(amount && (from != to)) {
		$('body').css('cursor','wait');
		$('#currency-converter-button').button('loading');
		$.ajax({
			method: "GET",
			url: "./bin/http/CimmClient.php",
			dataType: 'html',
			data:{
				a: amount,
				from: from,
				to: to
			},
			statusCode:{
				404: function() {
					alert('Unable to locate converter end point');
				}
			}		
		})
		.done(function(data, textStatus, jqXHR ){
			var result = $(data).find('#currency_converter_result .bld').html();
			if(result) {
				result = amount + ' ' + from + ' = ' + result;
				$('.currency-converter-result').addClass('bg-info').append('<span><strong>' + result + '</strong></span>');
			}else {
				$('.currency-converter-result').addClass('bg-warning').append('<span><strong>Failed. Check Connection</strong></span>');
			}
			
		})
		.fail(function(jqXHR, textStatus, errorThrown){
			$('.currency-converter-result').addClass('bg-warning').append('<span><strong>Check Connectivity!</strong></span>');
		})
		.always(function(jqXHR, textStatus, errorThrown){
			$('body').css('cursor','default');
			$('#currency-converter-button').button('reset');
		});	
	}else {
		$('.currency-converter-result').addClass('bg-danger').append('<span><strong>Invalid Conversion</strong></span>');
	}
});
	




