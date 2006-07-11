var ua = navigator.userAgent.toLowerCase();
var ie5mac = (!window.opera && ua.indexOf("msie")>-1 && ua.indexOf("mac")>-1);
var loaded;


if (window.clipboardData || (document.implementation && document.implementation.hasFeature("HTML", "1.0")))
{
	function createHTMLElement(tagName)
	{
		return document.createElementNS
			? document.createElementNS("http://www.w3.org/1999/xhtml", tagName)
			: document.createElement(tagName);
	}

	if (!document.createStyleSheet)
	{
		// createStyleSheet emulation
		document.createStyleSheet = function(cssHref)
		{
			var cssImporter = createHTMLElement("link");
			cssImporter.rel = "stylesheet";
			cssImporter.href = cssHref;
			if (headArr = document.getElementsByTagName("head"))
				return headArr[0].appendChild(cssImporter);
		}
	}

	document.createStyleSheet("css/menu.css");

	var currentMenu;
	var currentRoll;

	function getToObj(eventObj) { return eventObj ? eventObj.relatedTarget : event.toElement; }
	function findObj(obj, prop, val) { for (; obj.parentNode!=null; obj=obj.parentNode) if (obj[prop] == val) return obj; }
	function getSrcObj(eventObj) { return eventObj ? eventObj.target : event.srcElement; }

	if (window.HTMLElement)
	{
		HTMLElement.prototype.contains = function (oEl) {
			if (oEl == this) return true;
			if (oEl == null) return false;
			return this.contains(oEl.parentNode);		
		};
	}

	var menuTimeout, searchRoll;

	function resultRoll()
	{
		if (window.event && event.srcElement)
		{
			searchRoll = event.srcElement;
			event.srcElement.style.backgroundColor = '#bfcba1';
			event.srcElement.onmouseout = function()
			{	
				if (!searchRoll.contains(event.toElement)) searchRoll.style.backgroundColor = '';
			}
		}
	}

	document.onmouseover = function globalOver(e)
	{

		var srcObj = getSrcObj(e);

		if (srcObj && srcObj.tagName && srcObj.tagName.toLowerCase()=="a" && srcObj.className=="menuitem")
		{
			swapStyleBack();
			srcObj.originalStyle = srcObj.style.backgroundColor;
			srcObj.style.backgroundColor = "#ff9933";
			srcObj.title = "";
			srcObj.onmouseout  = swapStyleBack;
			currentRoll = srcObj;

			var testNode = srcObj;
			
			while (testNode.nextSibling)
			{
				testNode = testNode.nextSibling;

				if (testNode.className=="pop-menu")
				{
					showPopupMenu(testNode);
					srcObj.onmouseout = function(e)
					{
						if (currentMenu && currentMenu.contains(getToObj(e)))
							currentMenu.onmouseout = function(e) { if (!currentMenu || !currentMenu.contains(getToObj(e)) && getToObj(e)!=currentRoll) setMenuTimeout(); }
						else
							
							setMenuTimeout();
					}
					break;
				}
			}
		}
	}


	function setMenuTimeout()
	{
		if (currentMenu)
		{
			menuTimeout = setTimeout(swapStyleBack, 1200);
			currentMenu.onmouseover = function() { clearTimeout(menuTimeout); }
		}
	}

	function swapStyleBack()
	{
		if (currentRoll)
		{
			hidePopupMenu();
			currentRoll.style.backgroundColor = currentRoll.originalStyle;
			currentRoll.originalStyle = null;
			currentRoll = null;
		}
	}

	function showPopupMenu(menuObj)
	{
		// Stop IE from erroring if we access the DOM before HTML is loaded
		if (document.readyState && (document.readyState!="loaded" && document.readyState!="complete" && document.readyState!="interactive") && !loaded)
			return false;

		// Kill any currently shown menus
		hidePopupMenu();
		if (menuTimeout) clearTimeout(menuTimeout);
 
		// Add header, footer images - this is more than slightly ugly
		if (!menuObj.transformedMenu)
		{
			var bgObj = createHTMLElement("div");
			bgObj.className = "bg";

			if (menuObj.applyElement)
			{
				menuObj.applyElement(bgObj, "inside");
			}
			else
			{
				var newMenuObj = menuObj.cloneNode(false);
				var childs = menuObj.childNodes;
				for (var i=0; i<childs.length; i++) bgObj.appendChild(childs[i].cloneNode(true));
				newMenuObj.appendChild(bgObj);
				menuObj.parentNode.replaceChild(newMenuObj, menuObj);
				menuObj = newMenuObj;
			}

			

			if (!ie5mac)
			{
				var menuLinks = menuObj.getElementsByTagName("a");
				var menuLinksCount = menuLinks.length*1;

				for (var i=0; i<menuLinksCount; i++)
				{
					var newSpan = createHTMLElement("span");
					
					if (menuLinks[i].applyElement)
					{
						menuLinks[i].applyElement(newSpan, "inside");
					}
					else
					{
						var childNode = menuLinks[i].childNodes[0];
						newSpan.appendChild(childNode.cloneNode(true));
						menuLinks[i].replaceChild(newSpan, childNode);
					}
				}
			}

			menuObj.transformedMenu = true;
		}

		if (!document.body) document.body = document.getElementsByTagName("body")[0];

		var rootNode = (window.createPopup && document.compatMode=="CSS2Compat") ? document.documentElement : document.body;

		for (var obj=currentRoll, menuTop=0; obj && obj!=document.documentElement; obj=obj.offsetParent) menuTop += obj.offsetTop;
		var menuLeft = currentRoll.style.width;
		
		menuObj.style.top      = menuTop + "px";
//		menuObj.style.top      = (menuTop-2) + "px";
		menuObj.style.right     = "9.5em";
//		menuObj.style.height   = "auto";
		menuObj.style.overflow = "visible";
		menuObj.style.zIndex   = 1000;

		if (menuTop+menuObj.offsetHeight > rootNode.clientHeight+rootNode.scrollTop)
		{
			menuObj.style.top = ((rootNode.clientHeight+rootNode.scrollTop)-menuObj.offsetHeight) + "px";
		}

		if (menuObj.offsetHeight > rootNode.clientHeight)
		{
			menuObj.style.top       = rootNode.scrollTop + "px";
			menuObj.style.overflow  = "auto";
			menuObj.style.overflowX = "hidden";
			menuObj.style.height    = rootNode.clientHeight + "px";
		}

		currentMenu = menuObj;
	}

	function hidePopupMenu()
	{
		if (currentMenu)
		{
			//currentMenu.style.height = 0;
			//currentMenu.style.overflow = "hidden";
			currentMenu.style.right = "-500px";
			currentMenu = null;
			keybMenu = false;
		}
	}

	var keybMenu, menuTimeout;

	document.onactivate = document.onfocus = document.onkeydown = document.onkeypress = function(e)
	{
		// Allow keyboard access to menus
		if (window.showModalDialog && !window.createPopup) return false;

		var srcObj = e ? e.target : document.activeElement;

		if (srcObj && srcObj.parentNode && srcObj.tagName.toLowerCase()!="a" && srcObj.tagName.toLowerCase()=="span" && srcObj.parentNode.tagName.toLowerCase()=="a")
			srcObj=srcObj.parentNode;

		if (srcObj && srcObj.tagName && srcObj.tagName.toLowerCase()=="a")
		{
			var menuObj = (srcObj.nextSibling && srcObj.nextSibling.className=="pop-menu") ? srcObj.nextSibling : findObj(srcObj, "className", "pop-menu");
			
			if (menuObj && srcObj && srcObj.tagName.toLowerCase()=="a" && findObj(srcObj, "id", "menu"))
			{
				if (menuTimeout) clearTimeout(menuTimeout);
				swapStyleBack();
				currentRoll = menuObj.previousSibling;
				currentRoll.originalStyle = currentRoll.style.backgroundColor;
				currentRoll.style.backgroundColor = "#ff9933";
				showPopupMenu(menuObj);
				keybMenu = true;

				srcObj.onblur = function() { menuTimeout = setTimeout(function() { if (!keybMenu) swapStyleBack(); }, 500); }
			}
			else
			{
				hidePopupMenu();

				if (srcObj && srcObj.tagName && srcObj.tagName.toLowerCase()=="a" && currentRoll != srcObj)
				{
					if (menuTimeout) clearTimeout(menuTimeout);
					swapStyleBack();
					currentRoll = srcObj;
					currentRoll.originalStyle = currentRoll.style.backgroundColor;
					currentRoll.style.backgroundColor = "#ff9933";
				}
			}
		}
		else
		{
			hidePopupMenu();
		}
	}
}


document.onmouseup = function()
{
	var el;
	if (window.event && (el=event.srcElement) && el.tagName.toLowerCase()=="img" && el.parentNode.tagName.toLowerCase()=="label" && (el=document.getElementById(el.parentNode.htmlFor)))
		el.focus();
}