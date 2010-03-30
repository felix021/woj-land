//CodeHilighter v.85 
//File: codeh.js, chcommon.js, codeh.css
//Developed By Sandy_zc_1
//Date: 2009/6/23

  function HighLightCpp(str1)
  {
	var fstr1=new Object();
	fstr1.name1=cdh_Fill0(str1);

	str1=cdh_H2(str1,fstr1,/(\/\/.*)/gim,"shCmm1");
	str1=cdh_H3(str1,fstr1,/(\/\*(.|\n)*?\*\/)/gim,"shCmm1");
	str1=cdh_H3(str1,fstr1,/(^#(\\<br\/>\n|.)*)/gim,"shPre1");
	str1=cdh_H2(str1,fstr1,/(".*?")/gim,"shString1");
	str1=cdh_H2(str1,fstr1,/('.')/gim,"shString1");
	var re1=/\b(int|long|__int64|short|char|wchar_t|float|double|bool|void|signed|unsigned|true|false)\b/gm;
	str1=cdh_H2(str1,fstr1,re1,"shType1");
	var re1=/\b(for|while|do|if|else|switch|case|default|return|break|continue|goto|virtual|static|const|auto|register|volatile|mutable|extern|explicit|export|inline|typedef|using|namespace|template|typename|sizeof|typeid|operator|new|delete|public|protected|private|friend|struct|class|union|enum|try|catch|throw|this|static_cast|dynamic_cast|const_cast|reinterpret_cast)\b/gm;
	str1=cdh_H2(str1,fstr1,re1,"shReser1");
	var re1=/\b(BOOL|TRUE|FALSE|NULL|BYTE|WORD|DWORD|UINT|LPSTR|LPCSTR|LPTSTR|LPCTSTR|HANDLE|HDC|WINAPI|dllimport|dllexport|ASSERT|printf|scanf|std|vector|string|iterator)\b/gm;
	str1=cdh_H2(str1,fstr1,re1,"shCommon1");

	return str1;
  }
  function HighLightVB(str1)
  {
	var fstr1=new Object();
	fstr1.name1=cdh_Fill0(str1);

	str1=cdh_H2(str1,fstr1,/('.*)/gim,"shCmm1");
	str1=cdh_H2(str1,fstr1,/(Rem\b.*)/gim,"shCmm1");
	str1=cdh_H2(str1,fstr1,/(^#.*)/gim,"shPre1");
	str1=cdh_H3(str1,fstr1,/("(""|.)*?")/gim,"shString1");
	var re1=/\b(integer|long|byte|string|single|double|boolean|any|currency|date|variant|true|false|nothing)\b/gim;
	str1=cdh_H2(str1,fstr1,re1,"shType1");
	var re1=/\b(for|to|next|while|wend|do|loop|until|if|then|else|elseif|select|case|return|exit|end|on|error|raise|goto|call|event|withevents|static|const|type|with|implements|new|function|sub|property|byval|byref|optional|public|dim|as|private|friend|declare|lib|alias|class|enum|me|option|explicit|base|let|set|get|and|or|not|xor|mod|is)\b/gim;
	str1=cdh_H2(str1,fstr1,re1,"shReser1");
	var re1=/\b(form|picturebox|label|timer|left|right|mid|trim|ltrim|rtrim|space|instr|split|array|print|input|put|open|close|assert|createobject|filesystemobject|regexp|err|debug|app|screen|line|pset|paintpicture|circle)\b/gim;
	str1=cdh_H2(str1,fstr1,re1,"shCommon1");

	return str1;
  }
  function HighLightXML(str1,html1) 
  {
	var fstr1=new Object();
	fstr1.name1=cdh_Fill0(str1);

	str1=cdh_H3(str1,fstr1,/(&lt;!--(.|\n)*?--&gt;)/gim,"shCmm1");
	if (html1==true){
		str1=cdh_H3(str1,fstr1,/(&lt;%(.|\n)*?%&gt;)/gim,"shPre1");
	}
	str1=cdh_H2(str1,fstr1,/(".*?")/gim,"shString1");
	str1=cdh_H2(str1,fstr1,/(&lt;.*?&gt;)/gim,"shReser1");
	return str1;
  }
  function HighLightJava(str1)
  {
	var fstr1=new Object();
	fstr1.name1=cdh_Fill0(str1);

	str1=cdh_H2(str1,fstr1,/(\/\/.*)/gim,"shCmm1");
	str1=cdh_H3(str1,fstr1,/(\/\*(.|\n)*?\*\/)/gim,"shCmm1");
	str1=cdh_H2(str1,fstr1,/(".*?")/gim,"shString1");
	str1=cdh_H2(str1,fstr1,/('.')/gim,"shString1");
	var re1=/\b(int|long|short|byte|char|float|double|boolean|void|true|false|null)\b/gm;
	str1=cdh_H2(str1,fstr1,re1,"shType1");
	var re1=/\b(for|while|do|if|else|switch|case|return|break|continue|final|static|const|abstract|implements|extends|import|new|public|protected|private|class|interface|enum|try|catch|throw|throws|this|super)\b/gm;
	str1=cdh_H2(str1,fstr1,re1,"shReser1");
	var re1=/\b(System|out|in|gc|print|println|Object|Class|Math|Runtime|Thread|Character|String|StringBuffer|Integer|Double|Float|Long|Boolean|Byte|Error|Exception|IOException|RuntimeException)\b/gm;
	str1=cdh_H2(str1,fstr1,re1,"shCommon1");

	return str1;
  }
  function HighLightJS(str1)
  {
	var fstr1=new Object();
	fstr1.name1=cdh_Fill0(str1);

	str1=cdh_H2(str1,fstr1,/(\/\/.*)/gim,"shCmm1");
	str1=cdh_H3(str1,fstr1,/(\/\*(.|\n)*?\*\/)/gim,"shCmm1");
	str1=cdh_H2(str1,fstr1,/(".*?")/gim,"shString1");
	str1=cdh_H2(str1,fstr1,/('.')/gim,"shString1");
	var re1=/\b(for|in|while|do|if|else|switch|case|return|break|continue|new|delete|typeof|void|instanceof|var|function|try|catch|throw|throws|this)\b/gm;
	str1=cdh_H2(str1,fstr1,re1,"shReser1");
	var re1=/\b(RegExp|Array|Date|Boolean|Dictionary|Enumerator|FileSystemObject|Error|Global|Math|Number|object|String)\b/gm;
	str1=cdh_H2(str1,fstr1,re1,"shCommon1");
	return str1;
  }
  function HighLightCSharp(str1)
  {
	var fstr1=new Object();
	fstr1.name1=cdh_Fill0(str1);

	str1=cdh_H2(str1,fstr1,/(\/\/.*)/gim,"shCmm1");
	str1=cdh_H3(str1,fstr1,/(\/\*(.|\n)*?\*\/)/gim,"shCmm1");
	str1=cdh_H2(str1,fstr1,/(".*?")/gim,"shString1");
	str1=cdh_H2(str1,fstr1,/('.')/gim,"shString1");
	var re1=/\b(int|uint|long|ulong|short|ushort|sbyte|byte|char|decimal|float|double|bool|void|true|false|string)\b/gm;
	str1=cdh_H2(str1,fstr1,re1,"shType1");
	var re1=/\b(abstract|event|new|struct|as|explicit|switch|base|extern|this|operator|throw|break|finally|out|fixed|override|try|case|params|typeof|catch|for|private|foreach|protected|checked|goto|public|unchecked|class|if|readonly|unsafe|const|implicit|ref|continue|in|return|using|virtual|default|interface|sealed|volatile|delegate|internal|do|is|sizeof|while|lock|stackalloc|else|static|enum|var)\b/gm;
	str1=cdh_H2(str1,fstr1,re1,"shReser1");
	var re1=/\b(System|Runtime|IO|GC|Net|Console|Write|WriteLine|Read|ReadLine|Microsoft|Win32|Object|Type|Math|Thread|String|StringBuilder|Integer|Double|Float|Long|Boolean|Byte|Array|List|Dictionary|Error|Exception)\b/gm;
	str1=cdh_H2(str1,fstr1,re1,"shCommon1");

	return str1;
  }

  function HighLightPascal(str1)
  {
	var fstr1=new Object();
	fstr1.name1=cdh_Fill0(str1);

	str1=cdh_H2(str1,fstr1,/(\/\/.*)/gim,"shCmm1");
	str1=cdh_H3(str1,fstr1,/(\{(.|\n)*?\})/gim,"shCmm1");
	str1=cdh_H2(str1,fstr1,/('.')/gim,"shString1");
	var re1=/\b(integer|longint|shortint|word|byte|real|single|double|extended|comp|char|boolean|true|false|nil|string|file|record|array)\b/gim;
	str1=cdh_H2(str1,fstr1,re1,"shType1");
	var re1=/\b(begin|end|for|to|downto|do|while|repeat|until|if|then|else|case|of|goto|label|const|var|type|with|function|procedure|program|public|private|unit|export|uses|explicit|base|set|and|or|not|xor|div|mod|in)\b/gim;
	str1=cdh_H2(str1,fstr1,re1,"shReser1");
	var re1=/\b(object|constructor|destructor|implementation|inherited|interface|library|new|write|writeln|read|readln|abs|sin|cos|arctan|exp|ln|sqr|sqrt|int|frac|round|chr|ord|random)\b/gim;
	str1=cdh_H2(str1,fstr1,re1,"shCommon1");
 
	return str1;
  }
