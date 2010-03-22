function $(id) 
{
    return document.getElementById(id);
}

function encodePass(pass, seed)
{
    return hex_md5(hex_md5(pass) + seed);
}
