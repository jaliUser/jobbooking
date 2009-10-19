function role_id_changed(x) {
	window.location.href = document.location.href + "&role_id=" + x.value;
}

function check_form_customer(form) {
	var minPhoneLength = 8;
	if (form.name.value == "") {
    	alert( "Navn skal udfyldes!" );
    	form.name.focus();
    	return false ;
	}
	if ((form.phone.value.length < minPhoneLength || !isNumeric(form.phone.value)) &&
		(form.mobile.value.length < minPhoneLength || !isNumeric(form.mobile.value))) {    	
    	alert( "Fastnet eller mobil skal være et gyldigt tlf.nr!" );
    	form.phone.focus();
    	return false ;
	}
	return true;
}

function clearButtons(buttonGroup){
	for (i=0; i < buttonGroup.length; i++) {
		if (buttonGroup[i].checked == true) {
			buttonGroup[i].checked = false
		}
	}
}

function isNumeric(s){   
	var i;
    for (i = 0; i < s.length; i++)
    {   
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    // All characters are numbers.
    return true;
}
