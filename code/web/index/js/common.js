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

