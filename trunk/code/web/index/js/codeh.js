//CodeHilighter v.85 
//File: codeh.js, chcommon.js, codeh.css
//Developed By Sandy_zc_1
//Date: 2009/6/23

  function cdh_GetText(obj,isff)
  {
	var str1
	if(obj.tagName.toUpperCase()=="TEXTAREA")
	{
		str1=obj.value;
		str1=str1.replace(/</gim,"&lt;");
		str1=str1.replace(/>/gim,"&gt;");
		var rr2=/  /gim;
		str1=str1.replace(rr2,"&nbsp; ");
		var rr2=/\t/gim;
		str1=str1.replace(rr2,"&nbsp;&nbsp;&nbsp; ");	
		str1=str1.replace(/\n/gim,"<br/>");	
	}else
	{
		str1=obj.innerHTML;
	}
	return str1;
  }	
 function cdh_strMake1(len,char1)
  {
    var str1="";
	var s1;
	for(s1=0;s1<len;s1++)
	{
		str1=str1 +char1;
	}
	return str1;
  }  

  function cdh_H2(str1,_fstr1,re1,spclass)
  {
	var offset1=0;
	var fstr1=_fstr1.name1;
	var sm1=cdh_strMake1(spclass.length,"1");
	str1=str1.replace(re1,function(g1,s1,fi,sstr1){
				fi=fi+offset1;
				if(fstr1.charAt(fi)=="1"){return s1;}
				fstr1=fstr1.substr(0,fi)+"111111111111111"+sm1+cdh_Fill1(s1)+"1111111"+ fstr1.substr(fi+s1.length);
				offset1=offset1+22+spclass.length;
				return "<span class='"+spclass+"'>" +s1 +"</span>";
			});
	_fstr1.name1=fstr1;
	return str1;
  }
  function cdh_H3(str1,_fstr1,re1,spclass)
  {
	var offset1=0;
	var fstr1=_fstr1.name1;
	var sm1=cdh_strMake1(spclass.length,"1");
	str1=str1.replace(re1,function(g1,s1,s2,fi,sstr1){
				fi=fi+offset1;
				if(fstr1.charAt(fi)=="1"){return s1;}
				fstr1=fstr1.substr(0,fi)+"111111111111111"+sm1+cdh_Fill1(s1)+"1111111"+ fstr1.substr(fi+s1.length);
				offset1=offset1+22+spclass.length;
				return "<span class='"+spclass+"'>" +s1 +"</span>";
			});
	_fstr1.name1=fstr1;
	return str1;
  }
  function cdh_Fill0(str1)
  {
	return str1.replace(/.|\n/gim,'0');
  }
  function cdh_Fill1(str1)
  {
	return str1.replace(/.|\n/gim,'1');
  }

function CodeHilight(ObjDiv,language1)
{
	var isIE = navigator.userAgent.indexOf("MSIE") >= 0 ? true : false;
    var str1=cdh_GetText(document.getElementById(ObjDiv),!isIE);
	
	str1=str1.replace(/\n|\r/gim,"");
	str1=str1.replace(/<br>/gim,"<br/>");

	var rr1=/<br\/>/gim;
	str1=str1.replace(rr1,"<br/>\n");

	var rr2=/&nbsp;&nbsp;/gim;
	str1=str1.replace(rr2,"&nbsp; ");

	var lng=language1.toUpperCase();
	if(lng=="C++" || lng == "C")
	{
		str1=HighLightCpp(str1);
	}else if(lng=="VB")
	{
		str1=HighLightVB(str1);
	}else if(lng=="HTML")
    {
		str1=HighLightXML(str1,true);
	}else if(lng=="XML")
	{
		str1=HighLightXML(str1,false);
	}else if(lng=="JAVA")
	{
		str1=HighLightJava(str1);
	}else if(lng=="JS")
	{
		str1=HighLightJS(str1);
	}else if(lng=="CSHARP")
    {
	    str1=HighLightCSharp(str1);
    }
    else if (lng == "PASCAL")
    {
        //left undone
    }
	
	document.getElementById(ObjDiv).innerHTML=str1 ;
	
}
