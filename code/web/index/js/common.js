function $(id) 
{
    return document.getElementById(id);
}

function encodePass(pass, seed)
{
    return hex_md5(hex_md5(pass) + seed);
}

function createElement(name)
{
    return document.createElement(name);
}

function cmp_greater(a, b)
{
    return a > b;
}

function cmp_less(a, b)
{
    return a < b;
}

function qsort(arr, s, e, cmp)
{
    var i = s, j = e, t = arr[s];
    if (s < e)
    {
        while (i != j)
        {
            while (i < j && cmp(t, arr[j])) j--;
            if (i < j) 
            {
                arr[i] = arr[j];
                i++;
            }
            while (i < j && cmp(arr[i], t)) i++;
            if (i < j) {
                arr[j] = arr[i]; 
                j--;
            }
        }
        arr[i] = t;
        qsort(arr, s, i - 1, cmp);
        qsort(arr, i + 1, e, cmp);
    }
}

function htmlspecialchars(str)  
{  
    str = str.replace(/&/g, '&amp;');
    str = str.replace(/</g, '&lt;');
    str = str.replace(/>/g, '&gt;');
    str = str.replace(/"/g, '&quot;');
    str = str.replace(/'/g, '&#039;');
    return str;
}

function key_event(evt, func){
    evt = (evt) ? evt : ((window.event) ? window.event : null);
    if (!evt) return;
    try {
        var key = evt.keyCode ? evt.keyCode : evt.which;
        func(key);
    } catch (e) {
        alert(e);
    }  
}

var lang_names = ['Unknown', 'C', 'C++', 'Java', 'Pascal'];
function guess_lang(lang, src)
{
    var lang_maybe  = -1;
    if (src.indexOf('#include') >= 0 || src.indexOf('int main') >= 0)
    { //C || C++
        lang_maybe = 2;
        if (src.indexOf('iostream') >= 0 || src.indexOf('namespace') >= 0
                || src.indexOf('cstdio') >= 0) //C++
        {
            lang_maybe = 2;
        }
        else  //C
        {
            lang_maybe = 1;
            if (lang == 2)
                lang_maybe = 2; //C++兼容C
        }

    }
    else if (src.indexOf('java') > 0 || src.indexOf('System.out') >= 0 
            || src.indexOf('public class') >= 0)
    { //Java
        lang_maybe = 3;
    }
    else if ((/\bbegin\b/i).test(src) && (/\bend\b/i).test(src))
    { //pascal
        lang_maybe = 4;
    }
    else
    { //unknown
        lang_maybe = 0;
    }
    return lang_maybe;
}

function getXmlHTTP()
{
    var xmlHttp=null;
    try{
        //for IE
        try{ 
            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP"); 
        }
        catch(e1){ 
            xmlHttp = new ActiveXObject("MSXML2.XMLHTTP");
        }
    }catch(e2){
        //For others
        try{
            xmlHttp=new XMLHttpRequest;
        }
        catch(e2) {
            alert('Your browser do not support ajax, please try IE/FireFox/Chrome.');
        }
    }
    return xmlHttp;
}

function LoadURL(method, url, values, func)
{
    var xml = getXmlHTTP();
    if (xml == null)
    {
        alert('Operation failed');
        return;
    }
    try
    {
        xml.onreadystatechange = function()
        {
            if (xml.readyState == 4)
            {
                func(xml.status, xml.responseText);
            }
        }
        if (method == 'GET')
        {
            url += '?' + values;
            values = '';
        }
        xml.open(method, url, true);
        if (method == 'POST')
        {
            xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
        }
        xml.send(values);
    }
    catch(e)
    {
        alert(e);
        return;
    }
}

function PostURL(url, values, func)
{
    LoadURL('POST', url, values, func);
}

function replaceTextarea(id, height, width, toolbarset)
{
    var oFCKeditor = new FCKeditor(id) ;
    oFCKeditor.BasePath = '../editor/fckeditor/';
    oFCKeditor.ToolbarSet = toolbarset;
    oFCKeditor.Height   = height;
    oFCKeditor.Width    = width;
    //oFCKeditor.ReplaceTextarea() ;
    return oFCKeditor;
}
