/* display scripts: generate image legends */

function image_legends() {
	// security: are you DOM-enabled?
	/*
	if (!document.getElementById) return false;
	if (!document.getElementsByTagName) return false;
	if (!document.createElement) return false;
	if (!document.createTextNode) return false;
	*/

	if (!document.getElementById || !document.getElementsByTagName || !document.createElement || !document.createTextNode) return false;

	// OK, so you know the DOM
	// first we'll check if we're in an article and if there's a 'content' block in it
	//if (!document.getElementsByTagName('body')[0].className.match('article')) return false;

	if (document.getElementsByTagName('body')[0].className.match('article') && document.getElementById('content')) {
		/*
		// we gather the <span> collection, and look for spip_documents
		spans = document.getElementById('content').getElementsByTagName('span');
		if(spans.length>0) {
			for(var i=0; i<spans.length; i++) {
				if(spans[i].className.match('spip_documents')) {
					// we fetch the image
					myimg = spans[i].getElementsByTagName('img')[0];
					// ... then create a new title span, and append it to the spip_documents span
					t = document.createTextNode(myimg.getAttribute('title'));
					s = document.createElement('span');
					s.appendChild(t);
					// we have to set the span's width
					s.setAttribute("style","width:" + myimg.width + "px; display:block; ");
					myimg.parentNode.appendChild(s);
					// screen reader-friendly approach: let's empty the alt and title tags,
					// so that they're not read aloud twice
					myimg.setAttribute('alt','');
					myimg.setAttribute('title','');
				}
			}
		}
		*/
	} // end getElementById('content')
	else if(document.getElementsByTagName('body')[0].className.match('photo') && document.getElementById('photos')) {
		// we find all the photos
		var p = document.getElementById('photos');
		imgArray = p.getElementsByTagName('img');
		divArray = p.getElementsByTagName('div');
		if(imgArray.length>0) {
			for(var i=0; i<imgArray.length; i++) {
				tmpLongdesc = '';
				if(imgArray[i].getAttribute('longdesc')) {
					tmpLongdesc = imgArray[i].getAttribute('longdesc');
				}
				if(tmpLongdesc!='') {
					a = document.createElement('a');
					a.setAttribute('title',"Lire une description de la photo '" + imgArray[i].getAttribute('alt') + "'");
					a.setAttribute('href',tmpLongdesc);
					a.appendChild(document.createTextNode("D"));
					divArray[i].appendChild(a);
				}
			}
		}
	} //end getElementById('photos')
}

function initPage() {
    image_legends();
}

window.onerror=function() { return true; }
window.onload=initPage;
