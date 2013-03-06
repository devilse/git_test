//링크 한꺼번에 없애기
function bluring(){ 
if(event.srcElement.tagName=="A"||event.srcElement.tagName=="IMG") document.body.focus(); 
} 

document.onfocusin=bluring; 
//링크 없애기 끝

//if (window.Event)       //넷스케이프에서만 대문자 E.
//        document.captureEvents(Event.MOUSEUP); // mouse up 이벤트를 잡음

function nocontextmenu() // IE4에서만 적용, 다른 브라우저는 무시
{
	event.cancelBubble = true;
	event.returnValue = false;
	return false;
}

function norightclick(e)   // 다른 모든 브라우저에서 작동
{
	if (window.Event)   // 다시, IE 또는 NAV ?
	{
		if (e.which == 2 || e.which == 3)
			return false;
	}else
	if (event.button == 2 || event.button == 3)
	{
		event.cancelBubble = true;
		event.returnValue = false;
		return false;
	}
}

function ctrl_click()
{

	
	if( (event.ctrlKey == true) || (event.keyCode >= 112 && event.keyCode <= 123)) {   // event.keyCode >= 112 && event.keyCode <= 123(Function Key (F1~F12))

		event.keyCode = 0;
		
		//alert("키를 사용할 수 없습니다.");
		
		event.cancelBubble = true;
		event.returnValue = false;
		

	}
}

document.oncontextmenu = nocontextmenu;      // IE5+ 용
document.onmousedown = norightclick;      // 다른 브라우저 용
document.onkeydown = ctrl_click;      // 컨트롤키를 이용한 제어를 막는 부분

var pptLocation=1;		//PPT 위치구분변수
var b=1;  //버튼 구분 변수

var slideNum = -1;	//현재 슬라이드 번호
var slideFlag = 0;	// 자동 수동 여부, 0일땐 자동 1이면 수동

var buffer_mode = false;
var MediaReady = false;
var OldState = "";
var isActive = false;
var pmove;

// 시작 버튼 클릭
function PlayIt()
{
	if(MediaPlayer1.PlayState == 1 || MediaPlayer1.PlayState == 8 || MediaPlayer1.PlayState == 2 || MediaPlayer1.PlayState == 4 || MediaPlayer1.PlayState == 5 || MediaPlayer1.PlayState == 10)
	{
		MediaPlayer1.controls.play();
		buttononoff(1);
		b = 1;
	}
}

// 전체화면 버튼 클릭
function resizeFull() {    
	if(MediaPlayer1.PlayState == 3)
	{
		alert("키보드 왼쪽 상단의 Esc 키를 누르시면 원래 화면으로 돌아옵니다.");
		MediaPlayer1.fullScreen=true;
	}			
}

var objid;
var x;

function setVolume(obj)
{
	objid = obj.id;
	x = event.clientX - document.all[objid].style.posLeft
	//window.status = "마우스다운 : " + x;
}

// 마우스 클릭끝
function freeobj()
{
	objid = "";
}

// 플레이어 상태바 변화 보여주기
function printState() {    
	if (buffer_mode) {
		state_bar.value =  "버퍼링 " + MediaPlayer1.network.BufferingProgress + "%";
	}

    if (MediaPlayer1.playState != 3 && MediaPlayer1.playState != 4 && MediaPlayer1.playState != 5 && MediaPlayer1.playState != 1) return;

	$("#currentTime").text(time_paser(MediaPlayer1.controls.CurrentPosition));
	$("#allTime").text(time_paser(MediaPlayer1.currentMedia.duration));	
}

// 시각 파싱	
function time_paser(i_time){
	if(Math.floor(MediaPlayer1.currentMedia.duration) > 0){
		var PlyTime,PlyCl,PlyMin,PlySec,temp;	
		PlyTime=i_time;
		temp=Math.floor(PlyTime/60);
		PlySec=Math.floor(PlyTime%60);
		PlyClk=Math.floor(temp/60);
		PlyMin=Math.floor(temp%60);
		if (PlyMin <10 ) {PlyMin='0'+PlyMin;}
		if (PlySec <10) {PlySec='0'+PlySec;}
		if (PlyClk==0){r_TimeText=PlyMin+':'+PlySec;}else{r_TimeText=PlyClk+':'+PlyMin+':'+PlySec;}	
		return r_TimeText
	}else{
		return '00:00';
	}
}

// 상태변화	
function changePlayState(NewState)
{
	if (!MediaReady && NewState==3)
	{
		MediaReady = true;
		pmove = window.setInterval("posmove()", 500);		
	}
	
	if (NewState == OldState) return;
	
	if (NewState == 1) {
		OldState = NewState;
	} else if (NewState == 2) {
		OldState = NewState;
	} else if (NewState == 3) {
		OldState = NewState;
	} else if (OldState == 3 && NewState == 10) {
		OldState = 1;
	} else if(NewState == 8 ){
		OldState = 1;
	}
}

$(function () {    
    $("#btn_g").click(function () {
        if (MediaPlayer1.PlayState != 5) {
            MediaPlayer1.controls.FastReverse();
            buttononoff(4);
        }
    });

    $("#btn_f").click(function () {
        if (MediaPlayer1.PlayState != 4) {
            MediaPlayer1.controls.FastForward();
            buttononoff(5);
        }
    });

    $("#btn_stop").click(function () {
        if (MediaPlayer1.PlayState != 0) {
            MediaPlayer1.controls.Stop();
            MediaPlayer1.controls.currentPosition = 0;
            buttononoff(3);
        }
    });

    $("#btn_play").click(function () {
        //window.status = MediaPlayer1.PlayState;
        if (MediaPlayer1.PlayState == 3) {
            MediaPlayer1.controls.Pause();
            buttononoff(2);
        }
        else if (MediaPlayer1.PlayState == 2 || MediaPlayer1.PlayState == 1 || MediaPlayer1.PlayState == 4 || MediaPlayer1.PlayState == 5 || MediaPlayer1.PlayState == 8 || MediaPlayer1.PlayState == 10) {
            MediaPlayer1.controls.Play();
            buttononoff(1);
        }
    });
});

// 버튼 on, off 설정
function buttononoff(str1) {
    $("#btn_g").attr("src", imageRoot + "g.png");
    $("#btn_play").attr("src", imageRoot + "play.png");
    $("#btn_stop").attr("src", imageRoot + "stop.png");
    $("#btn_f").attr("src", imageRoot + "f.png");

    if (str1 == 1) {
        $("#btn_play").attr("src", imageRoot + "play_over.png");
	} else if(str1 == 2){
        $("#btn_play").attr("src", imageRoot + "pause_over.png");
	} else if(str1 == 3){
        $("#btn_stop").attr("src", imageRoot + "stop_over.png");
	} else if(str1 == 4){
        $("#btn_g").attr("src", imageRoot + "g_over.png");
	} else if(str1 == 5){
        $("#btn_f").attr("src", imageRoot + "f_over.png");
    }
}

// 음소거 버튼
function mute()
{
	if(MediaPlayer1.settings.mute == false){
		MediaPlayer1.settings.mute = true;
		document.b_mute.src = imageRoot + "b_sound_off.gif";
	}
	else
	{
		MediaPlayer1.settings.mute = false;
		document.b_mute.src = imageRoot + "b_sound_on.gif";
	}
}

/*****************************************************
// 강의창은 항상 포커스가 위에 있도록 하겠습니다.
//
******************************************************/
function onFocus()
{
	this.focus();
}