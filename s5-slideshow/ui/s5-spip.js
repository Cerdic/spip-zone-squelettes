function depart(toggle, prev, next)
    {
        startup();
        obj = document.getElementById("toggle");
        if (obj) obj.setAttribute('title',toggle),
        obj = document.getElementById("prev");
        if (obj) obj.setAttribute('title', prev);
        obj = document.getElementById("next");
        if (obj) obj.setAttribute('title', next);
        if (!obj) window.alert("attributs de navigation absents");	    
    }