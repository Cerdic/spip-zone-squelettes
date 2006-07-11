/* ***** BEGIN LICENSE BLOCK *****
 * This file is part of DotClear.
 * Copyright (c) 2004 Olivier Meunier and contributors. All rights
 * reserved.
 *
 * DotClear is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * DotClear is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with DotClear; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * ***** END LICENSE BLOCK ***** */
 
function dcWikiBar(textarea,img_path)
{
	this.addButton	= function() {}
	this.addSpace	= function() {}
	this.draw		= function() {}
	this.btStrong	= function() {}
	this.btEm		= function() {}
	this.btIns		= function() {}
	this.btDel		= function() {}
	this.btQ		= function() {}
	this.btCode		= function() {}
	this.btBr		= function() {}
	this.btBquote	= function() {}
	this.btPre		= function() {}
	this.btList		= function() {}
	this.btLink		= function() {}
	
	if (!document.createElement) {
		return;
	}
	
	if ((typeof(document["selection"]) == "undefined")
	&& (typeof(textarea["setSelectionRange"]) == "undefined")) {
		return;
	}
	
	var toolbar = document.createElement("div");
	toolbar.id = "dcwikibar";
	
	function addButton(src, title, fn) {
		var i = document.createElement('img');
		i.src = src;
		i.title = title;
		i.onclick = function() { try { fn() } catch (e) { } return false };
		i.tabIndex = 400;
		toolbar.appendChild(i);
		addSpace(2);
	}
	
	function addSpace(w)
	{
		s = document.createElement('span');
		s.style.padding='0 '+w+'px 0 0';
		s.appendChild(document.createTextNode(' '));
		toolbar.appendChild(s);
	}
	
	function encloseSelection(prefix, suffix, fn) {
		textarea.focus();
		var start, end, sel, scrollPos, subst;
		
		if (typeof(document["selection"]) != "undefined") {
			sel = document.selection.createRange().text;
		} else if (typeof(textarea["setSelectionRange"]) != "undefined") {
			start = textarea.selectionStart;
			end = textarea.selectionEnd;
			scrollPos = textarea.scrollTop;
			sel = textarea.value.substring(start, end);
		}
		
		if (sel.match(/ $/)) { // exclude ending space char, if any
			sel = sel.substring(0, sel.length - 1);
			suffix = suffix + " ";
		}
		
		if (typeof(fn) == 'function') {
			var res = (sel) ? fn(sel) : fn('');
		} else {
			var res = (sel) ? sel : '';
		}
		
		subst = prefix + res + suffix;
		
		if (typeof(document["selection"]) != "undefined") {
			var range = document.selection.createRange().text = subst;
			textarea.caretPos -= suffix.length;
		} else if (typeof(textarea["setSelectionRange"]) != "undefined") {
			textarea.value = textarea.value.substring(0, start) + subst +
			textarea.value.substring(end);
			if (sel) {
				textarea.setSelectionRange(start + subst.length, start + subst.length);
			} else {
				textarea.setSelectionRange(start + prefix.length, start + prefix.length);
			}
			textarea.scrollTop = scrollPos;
		}
	}
	
	function draw(msg) {
		p = document.createElement('em');
		p.style.display='block';
		p.style.margin='-0.5em 0 0.5em 0';
		p.appendChild(document.createTextNode(msg));
		textarea.parentNode.insertBefore(p, textarea);
		textarea.parentNode.insertBefore(toolbar, textarea);
	}
	
	
	// ---
	function singleTag(wtag,htag,wetag) {
		var stag = wtag;
		var etag = (wetag) ? wetag : wtag;
		encloseSelection(stag,etag);
	}
	
	function btStrong(label) {
		addButton(img_path+'bt_strong.png',label,
		function() { singleTag('{{','strong','}}'); });
	}
	
	function btEm(label) {
		addButton(img_path+'bt_em.png',label,
		function() { singleTag('{','em','}'); });
	}
	
	function btIns(label) {
		addButton(img_path+'bt_ins.png',label,
		function() { singleTag('++','ins'); });
	}
	
	function btDel(label) {
		addButton(img_path+'bt_del.png',label,
		function() { singleTag('__','del'); });
	}
	
	function btQ(label) {
		addButton(img_path+'bt_quote.png',label,
		function() { singleTag("''",'blockquote','}}'); });
	}
	
	function btCode(label) {
		addButton(img_path+'bt_code.png',label,
		function() { singleTag('@@','code'); });
	}
	
	function btBr(label) {
		addButton(img_path+'bt_br.png',label,
		function() {
			var tag = "\n_ ";
			encloseSelection('',tag);
		});
	}
		
	function btPre(label) {
		addButton(img_path+'bt_pre.png',label,
		function() { singleTag('<< ','pre',' >>'); });
	}
	
	function btList(label,type) {
		var img = (type == 'ul') ? 'bt_ul.png' : 'bt_ol.png';
		var wtag = (type == 'ul') ? '-*' : '-#';
		
		addButton(img_path+img,label,
		function() {
			encloseSelection("",'',
			function(str) {
				str = str.replace(/\r/g,'');
				return wtag+' '+str.replace(/\n/g,"\n"+wtag+' ');
			});
		});
	}
	
	function btLink(label,msg_url,msg_lang,default_lang) {
		addButton(img_path+'bt_link.png',label,
		function() {
			var href = window.prompt(msg_url,'');
			if (!href) { return; }
			stag = '[';
			var etag = '->'+href;
			etag = etag+']';
			
			encloseSelection(stag,etag);
		});
	}
		
	// methods
	this.addButton	= addButton;
	this.addSpace	= addSpace;
	this.draw		= draw;
	this.btStrong	= btStrong;
	this.btEm		= btEm;
	this.btIns		= btIns;
	this.btDel		= btDel;
	this.btQ		= btQ;
	this.btCode		= btCode;
	this.btBr		= btBr;
	this.btPre		= btPre;
	this.btList		= btList;
	this.btLink		= btLink;
}
