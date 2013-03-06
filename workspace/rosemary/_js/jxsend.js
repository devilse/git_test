var debugEngine = false;
function Engine(){
	this.xmlhttp = false;
	this.type = null;
	this.src = null;
	this.param = null;
	this.exec = null;
	this.ifrcnt = 0;
	this.iswait = false;

	this.execute = function(type, src, param, exec){
		//alert('type : '+type+' src : '+ src+' param : '+param + 'exec : '+ exec);
		this.type = type;
		this.src = src;
		this.param = param;
		this.exec = exec;
		this.getXmlHttpRequest();
		this.iswait = true;
		try{
			return this._execute();
		}catch (e){
			alert(e);
			this.errorHandle('실행하는데 실패하였습니다.');
		}
	}

	this.getXmlHttpRequest = function(){
		if(this.iswait == true){
			setTimeout("engine.getXmlHttpRequest();",200);
			return;
		}else{
			if(window.XMLHttpRequest){
				this.xmlhttp = new XMLHttpRequest();
			}else if (window.ActiveXObject && !(navigator.userAgent.indexOf('Mac') >= 0 && navigator.userAgent.indexOf("MSIE") >= 0)){
				this.xmlhttp = this._ActiveXObject(["Microsoft.XMLHTTP","Msxml2.XMLHTTP.5.0", "Msxml2.XMLHTTP.4.0", "MSXML2.XMLHTTP.3.0", "MSXML2.XMLHTTP"]);
			}
		}
	}

	this._ActiveXObject = function(axarray){
		var returnValue;
		for (var i = 0; i < axarray.length; i++){
			try{
				returnValue = new ActiveXObject(axarray[i]);
				break;
			}catch (ex){
			}
		}

		return returnValue;
	}

	this._execute = function(){

		if(this.type == 'GET') this.xmlhttp.open("GET",this.src, true);
		else if(this.type == 'POST') this.xmlhttp.open("POST",this.src, true);
		this.xmlhttp.setRequestHeader ("Content-type", this.type == 'POST' ? "application/x-www-form-urlencoded" : "text/html");
		this.xmlhttp.setRequestHeader ("Cache-Control", "no-cache");
		this.xmlhttp.setRequestHeader ("Pragma", "no-cache");
		this.xmlhttp.setRequestHeader ("Referer", this.src);
		this.xmlhttp.onreadystatechange = function(){
			if(engine.xmlhttp.readyState == 4 && engine.xmlhttp.status == 200){
				var result = engine.xmlhttp.responseText;
				result = result.replace(/\\\\/g,"\\")
				result = result.replace(/\\\n/g,"\n")
				engine.debugPrint(result);
				if(engine.exec){
					eval(engine.exec +'(result);');
				}
				engine.iswait = false;
			}
		}
		if(this.type == 'GET') this.xmlhttp.send(null);
		else if(this.type == 'POST') this.xmlhttp.send(this.param);
	}

	this.errorHandle = function(code){
		alert(code);
	}

	this.debugPrint = function(value){
		if(debugEngine == 'div'){
		}else if(debugEngine == 'alert'){
			alert(value);
		}else return;
	}
	this.Docode =  function(str){
		var varname = 'var_'+Math.ceil(Math.random()*10);
		str=str?str:this;
		eval(varname+'='+str);
		return window[varname];
	}
}
engine = new Engine();

function formData2QueryString(docForm){

	var strSubmitContent = '';
	var formElem;
	var strLastElemName = '';
	for(i = 0; i < docForm.elements.length; i++){

		formElem = docForm.elements[i];

		switch (formElem.type){
			case 'text':
			case 'hidden':
			case 'password':
			case 'textarea':
			case 'select-one':
				strSubmitContent += formElem.name + '=' + encodeURI(formElem.value).replace(/&/g,"$amp;") + '&'
				break;
			case 'radio':
				if (formElem.checked) {
					//alert(formElem.name);
					strSubmitContent += formElem.name + '=' + encodeURI(formElem.value).replace(/&/g,"$amp;") + '&'
					//strSubmitContent += formElem.name + '=' + formElem.value.replace(/&/g,"$amp;") + '&'
			}
				break;
			case 'checkbox':
				if (formElem.checked) {
					if (formElem.name == strLastElemName) {
						if (strSubmitContent.lastIndexOf('&') == strSubmitContent.length-1) strSubmitContent = strSubmitContent.substr(0, strSubmitContent.length - 1);
						strSubmitContent += ',' + encodeURI(formElem.value).replace(/&/g,"$amp;");
					}
					else {
						strSubmitContent += formElem.name + '=' + encodeURI(formElem.value).replace(/&/g,"$amp;");
					}
					strSubmitContent += '&';
					strLastElemName = formElem.name;
				}
				break;
		}
	}
	strSubmitContent = strSubmitContent.substr(0, strSubmitContent.length - 1);
	return strSubmitContent;
}

function __toJSON(arg){
	var i, o, u, v;
	arg = arg?arg:this;
	switch (typeof arg){
	case 'object':
		if(arg){
			if(arg.constructor == Array){
				o = '';
				for(i = 0; i < arg.length; ++i){
					v = __toJSON(arg[i]);
					if (o) o += ',';
					if (v !== u) {
						o += v;
					}else{
						o += 'null,';
					}
				}
				return '[' + o + ']';
			}else if (typeof arg.toString != 'undefined'){
				o = '';
				for(i in arg){
					v = __toJSON(arg[i]);
					if(v !== u){
						if (o) o += ',';
						o += __toJSON(i) + ':' + v;
					}
				}
				return '{' + o + '}';
			}else{
				return;
			}
		}
		return 'null';
	case 'unknown':
	case 'undefined':
	case 'function':
		return u;
	case 'string':
		return '"' + arg.replace(/(["\\])/g, '\\$1') + '"';
	default:
		return String(arg);
	}
}




JSON = {};
JSON.encode = __toJSON;

window.onload = function() {
  Object.prototype.toString = Array.prototype.toString = __toJSON;
}

//Object.prototype.toString = Array.prototype.toString = __toJSON;

function formNData2QueryString(docForm){

	var strSubmitContent = '';
	var formElem;
	var strLastElemName = '';
	for(i = 0; i < docForm.elements.length; i++){

		formElem = docForm.elements[i];
		switch (formElem.type){
			case 'text':
			case 'hidden':
			case 'password':
			case 'textarea':
			case 'select-one':
				strSubmitContent += formElem.name + '=' + formElem.value.replace(/&/g,"$amp;") + '&'
				break;
			case 'radio':
				if (formElem.checked) strSubmitContent += formElem.name + '=' + formElem.value.replace(/&/g,"$amp;") + '&'
				break;
			case 'checkbox':
				if(formElem.checked){
					if(formElem.name == strLastElemName){
						if (strSubmitContent.lastIndexOf('&') == strSubmitContent.length-1) strSubmitContent = strSubmitContent.substr(0, strSubmitContent.length - 1);
						strSubmitContent += ',' + formElem.value.replace(/&/g,"$amp;");
					}else{
						strSubmitContent += formElem.name + '=' + formElem.value.replace(/&/g,"$amp;");
					}
					strSubmitContent += '&';
					strLastElemName = formElem.name;
				}
				break;
		}
	}
	strSubmitContent = strSubmitContent.substr(0, strSubmitContent.length - 1);
	return strSubmitContent;
}
function NewWindow(u,n,w,h,f,p,x,y){
	var ws=window.screen?1:0,m=Math,C='center',R='random',M='custom',sw=screen.availWidth,sh=screen.availHeight,w=(w)?w:sw,h=(h)?h:sh,T=(p==C&&ws||!p)?(sh-h)/2:(p==R&&ws)?(m.floor(m.random()*(sh-h))):(p==M&&h!=sh)?y:0,L=(p==C&&ws||!p)?(sw-w)/2:(p==R&&ws)?(m.floor(m.random()*(sw-w))):(p==M&&w!=sw)?x:0,s='width='+w+',height='+h+',top='+T+',screeny='+T+',left='+L+',screenx='+L;
	s+=(!f||f=='')?'':','+f;
	var win=window.open((u)?u:'http://www.gample.net/',(n)?n:'',s);
	if(win && !win.closed){
		win.focus();
		return win;
	}
	if(!win)
		document.location=u;
}
function modalWindow(fn,u,n,w,h,f,p,x,y){
	var win			= null;
	var resizable	= (f!=null)?/resizable/.test(f):false;
	var status		= (f!=null)?/status/.test(f):false;
	var scroll		= (f!=null)?/scroll/.test(f):false;
	var mFeatures	= [	"center:"+(p.toLowerCase()=="center"?1:0),
						"dialogHeight:"+h+"px",
						"dialogWidth:"+w+"px",
						"help:no",
						"resizable:0",
						"status:0",
						"scroll:"+(scroll==true?1:0),
						"edge:raised","unadorned:yes"];
	if(x!=null && mFeatures[0]==1)mFeatures.push("dialogLeft:"+x+"px");
	if(y!=null && mFeatures[0]==1)mFeatures.push("dialogTop:"+y+"px");
	//if("undefined"!=typeof window.showModelessDialog){
	//	win=window.showModelessDialog(u,n,mFeatures.join(';'));
	if("undefined"!=typeof window.showModalDialog){
		result=window.showModalDialog(u,n,mFeatures.join(';'));
		eval(fn +'(result);');
	} else {
		h -= 46;
		w -= 2;
		win=NewWindow(u,n,w,h,f+',modal=yes',p,x,y);
	}
	return win;
}