	function verifI(){ 
	if (document.invitation.Nom.value == ""){
	alert("Vous avez oublié d'indiquer votre prénom."); 
	document.invitation.Nom.focus();
 	return (false);
	}
		
	if (document.invitation.Email.value == ""){
 	alert("Vous avez oublié d'indiquer votre e-mail.");
	document.invitation.Email.focus();
 	return (false);
 	}
	
	if (!isEmailAddr(document.invitation.Email.value)){
 	alert("Entrer un email valide: nom@domaine.com");
	document.invitation.Email.focus();
 	return (false);
 	}
	
	if (document.invitation.Nom_ami.value == ""){
 	alert("Vous avez oublié d'indiquer le prénom de votre ami.");
	document.invitation.Nom_ami.focus();
 	return (false);
 	}
		
	if (document.invitation.Email_ami.value == ""){
 	alert("Vous avez oublié d'indiquer l'e-mail de votre ami.");
	document.invitation.Email_ami.focus();
 	return (false);
 	}
	
	if (!isEmailAddr(document.invitation.Email_ami.value)){
 	alert("Entrer un email valide: nom@domaine.com");
	document.invitation.Email_ami.focus();
 	return (false);
 	}
	return true && alert("Merci de votre recommandation. Elle a été envoyée avec succès à votre ami(e)")
	}
	
