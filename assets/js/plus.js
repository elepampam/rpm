$(document).ready(function(){
	$(".dropdown-button").dropdown();
	 $(".button-collapse").sideNav();
	  $('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 15, // Creates a dropdown of 15 years to control year
    format: 'dd/mm/yyyy'  
  });
       $('.modal-trigger').leanModal();
       $('select').material_select();
       
  });

function format() {
    var no = document.getElementById("nofaktur");
    var temp;
    var stringFaktur = no.value;
    if (stringFaktur.length > 3) {
    	if (stringFaktur.charAt(3) != '.') {
    		temp = stringFaktur.substr(0,3);
    		stringFaktur = temp+'.'+stringFaktur.substr(3,stringFaktur.length-3);	
    	}; 
        if (stringFaktur.length > 7) {
            if (stringFaktur.charAt(7) != '-') {
                temp = stringFaktur.substr(0,7);
                stringFaktur = temp+'-'+stringFaktur.substr(7,stringFaktur.length-7);           
            };    
            if (stringFaktur.length > 10) {
                if (stringFaktur.charAt(10) != '.') {
                    temp = stringFaktur.substr(0,10);
                    stringFaktur = temp+'.'+stringFaktur.substr(10,stringFaktur.length-10);           
                };    
            };  
        };         
    };
    
    no.value = stringFaktur;
}

function formatNPWP(){
    var no = document.getElementById("nonpwp");
    var temp;
    var stringNpwp = no.value;
    if (stringNpwp.length > 2) {
        if (stringNpwp.charAt(2) != '.') {
            temp = stringNpwp.substr(0,2);
            stringNpwp = temp+'.'+stringNpwp.substr(2,stringNpwp.length-2);
        };
        if (stringNpwp.length > 6) {
            if (stringNpwp.charAt(6) != '.') {
                temp = stringNpwp.substr(0,6);
                stringNpwp = temp+'.'+stringNpwp.substr(6,stringNpwp.length-6);
            };   
            if (stringNpwp.length > 10) {
                if (stringNpwp.charAt(10) != '.') {
                    temp = stringNpwp.substr(0,10);
                    stringNpwp = temp+'.'+stringNpwp.substr(10,stringNpwp.length-10);
                };
                if (stringNpwp.length > 12) {
                    if (stringNpwp.charAt(12) != '-') {
                        temp = stringNpwp.substr(0,12);
                        stringNpwp = temp+'-'+stringNpwp.substr(12,stringNpwp.length-12);
                    };
                    if (stringNpwp.length > 16) {
                        if (stringNpwp.charAt(16) != '.') {
                            temp = stringNpwp.substr(0,16);
                            stringNpwp = temp+'.'+stringNpwp.substr(16,stringNpwp.length-16);
                        };
                    };
                };
            };   
        };        
    };;
    no.value = stringNpwp;
}

function hitungppn(pembagi){    
    var dpp = document.getElementById('dpp');
    var ppn = document.getElementById('ppn');

    if (pembagi > 0) {
        ppn.value = Math.round(dpp.value /pembagi);
        document.getElementById('ppn').focus();
    }
    else{
        ppn.value = 0;
    }    
}

function radiofunc(kata){
    var radio = kata;
    var nofaktur = document.getElementById("nofaktur");
    if (radio == 2) {
        nofaktur.value = "";
        nofaktur.setAttribute('disabled', 'disabled'); 
        nofaktur.setAttribute('placeholder','Faktur menyusul tidak perlu diberikan no faktur');
    }
    else{
        nofaktur.removeAttribute('disabled'); 
        nofaktur.setAttribute('placeholder','00X.XXX.XX.XXXXXXXX');
    }
    // alert(radio);
}

function radiofunc2(pembagi){
    var nilai = pembagi;
    // console.log(nilai);
    var ppn = document.getElementById('ppn');
    if (nilai == 3) {
        $("#dpp").attr('onfocusout','hitungppn(0)'); 
        ppn.value = "0";       
    }
    else{
        $("#dpp").attr('onfocusout','hitungppn(10)'); 
        // hitungppn(10);
    }       
}

function cekrekon(value){
    var status = value;
    var date1 = document.getElementById("date1");
    var date2 = document.getElementById("date2");
    if (status != 'SK') {
        // date1.value = " ";
        // date2.value = " ";
        date1.setAttribute('disabled', 'disabled'); 
        date2.setAttribute('disabled', 'disabled'); 
    } else{
        date1.removeAttribute('disabled');
        date2.removeAttribute('disabled');
    };
}

// function cekangka(){
//     var dpp = document.getElementById('dpp');
//     var temp = dpp.value;
//     if (event.keyCode >=48 && event.keyCode <= 57) {
        
//     }
//     else
//         dpp.value = temp.substr(0,temp.length-);
// }

