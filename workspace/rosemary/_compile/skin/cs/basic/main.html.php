<?php /* Template_ 2.2.7 2013/01/10 17:08:24 C:\rosemary\trunk\src\rosemary\_template\skin\cs\basic\main.html 000019041 */ ?>
<script type="text/javascript">
$(function () {
$("#event_img").jQBanner({	//롤링을 할 영역의 ID 값
nWidth: 789, 				//영역의 width
nHeight: 174, 			//영역의 height
nCount: 3, 				//돌아갈 이미지 개수
isActType: "left", 			//움직일 방향 (left, right, up, down
nOrderNo: 1, 				//초기 이미지
nDelay: 5000, 				//롤링 시간 타임 (1000 = 1초)
isBtnType: "li"			//라벨(버튼 타입) - 여기는 안쓰임
});
});
</script>
<!-- 메인베너 영역 시작 -->
<!-- 오버했을때 베너 영역 시작 -->
<div id="category">
<div id="left_gm1" style="display:none;">
<div class="left_gm_box">
기술사 기능장
</div>
</div>
<div id="left_gm2" style="display:none;">
<div class="left_gm_box">
기사 산업기사
</div>
</div>
<div id="left_gm3" style="display:none;">
<div class="left_gm_box">
기능사
</div>
</div>
<div id="left_gm4" style="display:none;">
<div class="left_gm_box">
학위취득 추천자격증
</div>
</div>
<div id="left_gm5" style="display:none;">
<div class="left_gm_box">
공무원가산점 추천자격증
</div>
</div>
<!-- 오버했을때 베너 영역 끝 -->
<div class="indexbanner">
<ul class="m_bn_list">
<a href="#"><li class="bn01"><span class="blind">기술사.기능장</span></li></a>
<a href="#"><li class="bn02"><span class="blind">기사.산업기사</span></li></a>
<a href="#"><li class="bn03"><span class="blind">기능사</span></li></a>
<a href="#"><li class="bn04"><span class="blind">학위취득 추천자격증</span></li></a>
<a href="#"><li class="bn05"><span class="blind">공무원가산점 추천자격증</span></li></a>
</ul>
<!--기본메인베너메인 베너 -->
<div class="m_bn">
<div id="event_img">
<div class="clsBannerScreen">
<div class="images" style="display:block;">
<a href="#"><img src="/_template/skin/cs/basic/images/event01.gif" alt="라이패스오픈이벤트" /></a>
</div>
<div class="images">
<a href="#"><img src="/_template/skin/cs/basic/images/event01.gif" alt="라이패스오픈이벤트" /></a>
</div>
<div class="images">
<a href="#"><img src="/_template/skin/cs/basic/images/event01.gif" alt="라이패스오픈이벤트" /></a>
</div>
</div>
<ul class="clsBannerButton event_num">
<li overclass="labelOverClass" outclass="">
<a href="#" title="">1+1오픈이벤트</a>
</li>
<li overclass="labelOverClass" outclass="">
<a href="#" title="">회원가입특전</a>
</li>
<li overclass="labelOverClass" outclass="">
<a href="#" title="">1년+2개월! 연간회원권!</a>
</li>
</ul>
</div>
</div>
</div>
</div>
<!-- 메인베너 영역 시작 -->
<!-- 메인베너 하단 강조 랑크 시작 -->
<div class="spot">
<a href="../board/index.php?bo_num=69628"><img src="/_template/skin/cs/basic/images/spot_04.gif" alt="기출문제 자료실" title="기출문제 자료실"/></a>
<a href="../content/index.php?cid=counseltime"><img src="/_template/skin/cs/basic/images/spot_05.gif" alt="실시간 상담" title="실시간 상담"/></a>
<a href="../faq/index.php"><img src="/_template/skin/cs/basic/images/spot_06.gif" alt="라이패스 FAQ" title="라이패스 FAQ"/></a>
<a href="../content/index.php?cid=counseldown"><img src="/_template/skin/cs/basic/images/spot_07.gif" alt="학습 프로그램" title="학습 프로그램"/></a>
</div>
<!-- 메인베너 하단 강조 랑크 끝 -->
<!-- 컨텐츠 영역 시작 -->
<div id="content">
<!-- 컨텐츠 탑 영역 시작 -->
<div class="t_main">
<!-- 학습설계상담 시작 -->
<div class="lecture">
<h3><img src="/_template/skin/cs/basic/images/lecture.gif"alt="학습설계상담" title="학습설계상담"/></h3>
<p>
<img src="/_template/skin/cs/basic/images/num_1.gif"alt="1"/>
<img src="/_template/skin/cs/basic/images/num_5.gif"alt="5"/>
<img src="/_template/skin/cs/basic/images/num_8.gif"alt="8"/>
<img src="/_template/skin/cs/basic/images/num_8.gif"alt="8"/>
<img src="/_template/skin/cs/basic/images/num_-.gif"alt="-"/>
<img src="/_template/skin/cs/basic/images/num_7.gif"alt="7"/>
<img src="/_template/skin/cs/basic/images/num_6.gif"alt="6"/>
<img src="/_template/skin/cs/basic/images/num_1.gif"alt="1"/>
<img src="/_template/skin/cs/basic/images/num_2.gif"alt="2"/>
</p>
<input type="text"name="lec_name"class="lec_name"maxlength="10"/><span class="blind">이름입력창</span>
<input type="text"name="lec_num"class="lec_num"maxlength="20"/><span class="blind">전화번호입력창</span>
<textarea name="comment"class="combox"rows="3"cols="20"></textarea><span class="blind">메모입력창</span>
<img class="lectext" src="/_template/skin/cs/basic/images/lectext.gif"alt="빠른 상담을 위해 정보를 정확히 입력하세요"/>
<span><input type="button" name="lec_btn" class="lec_btn lect_btn" alt="상담신청클릭"/></span>
</div>
<!-- 학습설계상담 끝 -->
<!-- 학위취득 연계과정 찾기 시작 -->
<!--<div class="linked_lec">
<h3><img src="/_template/skin/cs/basic/images/linked.gif"alt="학위취득 학점인정 연계과정 찾기"/></h3>
<input type="radio"name="radio2" class="radio2"/><label for name="degree2">학위명 검색</label>
<input type="radio"name="radio2" class="radio2"/><label for name="licen2">자격증명 검색</label>
<input type="radio"name="radio2" class="radio2"/><label for name="lectu2">강좌명 검색</label>
<input type="text" name="linked_searchbox"class="linked_searchbox" maxlength="max"/><span class="blind">학위명, 자격증명 입력창</span>
<input type="button" name="linked_searchbtn"class="linked_searchbtn"/><span class="blind">학위명, 자격증 입력버튼 </span>
<ul>
<li><a href="#"><span>학점 인정 </span>기준</a></li>
<li><a href="#"><span>학점 인정 </span>기준표</a></li>
<li><a href="#"><span>전공별 자격 </span>연계표</a></li>
</ul>
</div>-->
<!-- 학위취득 연계과정 찾기 끝 -->
<!-- 게시판추출 -->
<div class="noticebox_b">
<ul class="notice_tab">
<li class="tab_now">공지사항</li>
<li class="n_left">시험뉴스</li>
<li class="n_left">이벤트</li>
<li class="s_more"><img src="/_template/skin/cs/basic/images/btn_s_more.gif" alt="more" /></li>
</ul>
<ul class="notice_list">
<li><a href="#">학위취득일 이전에 이수한 학습</a><span class="list_date">2012-12-25</span></li>
<li><a href="#">2012년 8월(후기) 학위대상자 학위수여</a><span class="list_date">2012-12-25</span></li>
<li><a href="#">부정 학습에 따른 학점 및 학위 취소</a><span class="list_date">2012-12-25</span></li>
<li><a href="#">2012년 2학기 3기수 학사일정</a><span class="list_date">2012-12-25</span></li>
<li><a href="#">2012년 후기 학위증 우편신청 및 방문</a><span class="list_date">2012-12-25</span></li>
<li><a href="#">2012년 7월(후기) 학위대상자 학위수여</a><span class="list_date">2012-12-25</span></li>
</ul>
</div>
<!-- 게시판추출 끝 -->
<!-- 추천교재 -->
<div class="book_rec">
<a href="#"><img src="/_template/skin/cs/basic/images/tit_book.gif" alt="추천교재"/></a>
<ul>
<li class="btn_up"><a href="#"><img src="/_template/skin/cs/basic/images/up_prev.gif" alt="이전"/></a></li>
<li><img src="/_template/skin/cs/basic/images/book1.gif" alt="" /><br />생활영어</li>
<li><img src="/_template/skin/cs/basic/images/book2.gif" alt="" /><br />주니어영어</li>
<li class="btn_up"><a href="#"><img src="/_template/skin/cs/basic/images/up_next1.gif" alt="다음"/></a></li>
</ul>
</div>
<!-- 추천교재 끝 -->
<!-- 고객센터 시작 -->
<div class="customer_center">
<h3><img src="/_template/skin/cs/basic/images/customer.png" alt="고객센터"/></h3>
<span><img src="/_template/skin/cs/basic/images/callnum.png" alt="고객센터 대표번호:1577-1212 ,070-7589-0645, 070-7589-0646"/></span>
<p><img src="/_template/skin/cs/basic/images/jobtime.png" alt="근무시간 평일 10:00~19:00, 주말 10:00~19:00"/></p>
</div>
<!-- 고객센터 끝 -->
<!-- 합격수기 시작 -->
<div class="pass_memo">
<h3><span class="blind">합격수기</span></h3>
<img class="pass_photo" src="/_template/skin/cs/basic/images/pass_photo.gif" alt="회원사진"/>
<div class="pass_info">
<a href="#"><strong>시각디자인산업기사 취득</strong></a>
<p>이미은 회원님</p>
</div>
<p class="pmemo"><a href="#">연간회원으로 할인혜택 받아서 일단 저렴하게 수강하고 합격해서 너무너무 좋아요.</a></p>
</div>
<!-- 합격수기 끝 -->
<!-- 업데이트 강좌 시작 -->
<div class="up_lec">
<h3><img src="/_template/skin/cs/basic/images/up_lec.gif" alt="업데이트 강좌"></h3>
<ul class="up_arrow">
<li><a href="#"><img src="/_template/skin/cs/basic/images/up_prev.gif" alt="이전강좌"/></a></li>
<li><a href="#"><img src="/_template/skin/cs/basic/images/up_next.gif" alt="다음강좌"/></a></li>
</ul>
<ul class="up_lnfo">
<li><a href="#"></a><img class="up_photo"src="/_template/skin/cs/basic/images/up_photo.gif" alt="강사사진"/></a></li>
<li><img src="/_template/skin/cs/basic/images/uplec_name.gif" alt="강좌분류 국가기술" /></li>
<li><span>기계설비</span></li>
<li>최희영 교수</li>
</ul>
</div>
<!-- 업데이트 강좌 끝 -->
</div>
<!-- 컨텐츠 탑 영역 끝 -->
<!-- 추천 유망자격증 영역 시작 -->
<div class="hot_licence">
<!-- 추천 유망자격증 탑 영역 시작 -->
<div class="hot_top">
<h3><img src="/_template/skin/cs/basic/images/m_maintop.gif" alt="추천! 2013 유망 자격증" /></h3>
<ul>
<li><a href="#"><img src="/_template/skin/cs/basic/images/up_prev.gif" alt="이전강좌"/></a></li>
<li><a href="#"><img src="/_template/skin/cs/basic/images/up_next.gif" alt="다음강좌"/></a></li>
</ul>
</div>
<!-- 추천 유망자격증 탑 영역 끝 -->
<!-- 추천 유망자격증 강좌 정보 1 시작 -->
<div class="hot_lec">
<img class="photo_b"src="/_template/skin/cs/basic/images/hot_photo1.gif" alt="강사사진"/>
<ul>
<li class="hot_first"><a href="#"><strong>컨벤션 기획사 1급</strong></a><img src="/_template/skin/cs/basic/images/newbl.gif" alt="신규등록"/></li>
<li><span>최우영 교수</span></li>
<li class="red_text"><a href="#">9월 모평 이후 남은 50일동안 집중학습법!</a></li>
<input type="button" name="white_btn" class="white_btn" value="자세히보기"/>
<input type="button" name="brown_btn" class="brown_btn" value="수강신청"/>
</ul>
</div>
<!-- 추천 유망자격증 강좌 정보 1 끝 -->
<!-- 추천 유망자격증 강좌 정보 2 시작 -->
<div class="hot_lec">
<img class="photo_b"src="/_template/skin/cs/basic/images/hot_photo2.gif" alt="강사사진"/>
<ul>
<li class="hot_first"><a href="#"><strong>도로교통사고감정사</strong></a></li>
<li><span>최우영 교수</span></li>
<li class="red_text"><a href="">9월 모평 이후 남은 50일동안 집중학습법!</a></li>
<input type="button" name="white_btn" class="white_btn" value="자세히보기"/>
<input type="button" name="brown_btn" class="brown_btn" value="수강신청"/>
</ul>
</div>
<!-- 추천 유망자격증 강좌 정보 2 끝 -->
<!-- 추천 유망자격증 강좌 정보 3 시작 -->
<div class="hot_lec">
<img class="photo_b"src="/_template/skin/cs/basic/images/hot_photo3.gif" alt="강사사진"/>
<ul>
<li class="hot_first"><a href="#"><strong>주택관리사</strong></a><img src="/_template/skin/cs/basic/images/newbl.gif" alt="신규등록"/></li>
<li><span>최우영 교수</span></li>
<li class="red_text"><a href="#">9월 모평 이후 남은 50일동안 집중학습법!</a></li>
<input type="button" name="white_btn" class="white_btn" value="자세히보기"/>
<input type="button" name="brown_btn" class="brown_btn" value="수강신청"/>
</ul>
</div>
<!-- 추천 유망자격증 강좌 정보 3 끝 -->
</div>
<!-- 추천 유망자격증 영역 끝 -->
<!-- 라이패스 인기강좌 시작 -->
<div class="popular_lec">
<!-- 라이패스 인기강좌 탑 영역 시작 -->
<div class="popular_top">
<h3><img src="/_template/skin/cs/basic/images/popular_lec.gif" alt="라이패스 인기강좌"/></h3>
<ul>
<li><a href="#"><img src="/_template/skin/cs/basic/images/up_prev.gif" alt="이전강좌"/></a></li>
<li><a href="#"><img src="/_template/skin/cs/basic/images/up_next.gif" alt="다음강좌"/></a></li>
</ul>
</div>
<!-- 라이패스 인기강좌 탑 영역 끝 -->
<!-- 라이패스 인기강좌 정보 1 시작 -->
<div class="popular_register">
<p><img src="/_template/skin/cs/basic/images/popular_photo1.gif" alt="강사사진"/></p>
<ul class="pop_list">
<li class="pop_list_first"><a href="#"><strong>영어전문번역사</strong></a></li>
<li><span>최우영 교수</span></li>
<li>
<ul class="star">
<li><img src="/_template/skin/cs/basic/images/starO.gif" alt="별점O"/></li>
<li><img src="/_template/skin/cs/basic/images/starO.gif" alt="별점O"/></li>
<li><img src="/_template/skin/cs/basic/images/starO.gif" alt="별점O"/></li>
<li><img src="/_template/skin/cs/basic/images/starO.gif" alt="별점O"/></li>
<li><img src="/_template/skin/cs/basic/images/starO.gif" alt="별점O"/></li>
</ul>
</li>
<input type="button" name="white_btn" class="white_btn pop_lec_btn" value="자세히보기"/>
<input type="button" name="brown_btn" class="red_btn pop_lec_btn" value="수강신청"/>
</dl>
</div>
<!-- 라이패스 인기강좌 정보 1 끝 -->
<!-- 라이패스 인기강좌 정보 2 시작 -->
<div class="popular_register">
<p><img src="/_template/skin/cs/basic/images/popular_photo2.gif" alt="강사사진"/></p>
<ul class="pop_list">
<li class="pop_list_first"><a href="#"><strong>전산세무회계</strong></a></li>
<li><span>최우영 교수</span></li>
<li>
<ul class="star">
<li><img src="/_template/skin/cs/basic/images/starO.gif" alt="별점O"/></li>
<li><img src="/_template/skin/cs/basic/images/starO.gif" alt="별점O"/></li>
<li><img src="/_template/skin/cs/basic/images/starO.gif" alt="별점O"/></li>
<li><img src="/_template/skin/cs/basic/images/starO.gif" alt="별점O"/></li>
<li><img src="/_template/skin/cs/basic/images/starO.gif" alt="별점O"/></li>
</ul>
</li>
<input type="button" name="white_btn" class="white_btn pop_lec_btn" value="자세히보기"/>
<input type="button" name="brown_btn" class="red_btn pop_lec_btn" value="수강신청"/>
</dl>
</div>
<!-- 라이패스 인기강좌 정보 2 끝 -->
<!-- 라이패스 인기강좌 정보 3 시작 -->
<div class="popular_register">
<p><img src="/_template/skin/cs/basic/images/popular_photo3.gif" alt="강사사진"/></p>
<ul class="pop_list">
<li class="pop_list_first"><a href="#"><strong>기능9급공무원</strong></a><img src="/_template/skin/cs/basic/images/newbl.gif" alt="신규등록"/></li>
<li><span>최우영 교수</span></li>
<li>
<ul class="star">
<li><img src="/_template/skin/cs/basic/images/starO.gif" alt="별점O"/></li>
<li><img src="/_template/skin/cs/basic/images/starO.gif" alt="별점O"/></li>
<li><img src="/_template/skin/cs/basic/images/starX.gif" alt="별점X"/></li>
<li><img src="/_template/skin/cs/basic/images/starX.gif" alt="별점X"/></li>
<li><img src="/_template/skin/cs/basic/images/starX.gif" alt="별점X"/></li>
</ul>
</li>
<input type="button" name="white_btn" class="white_btn pop_lec_btn" value="자세히보기"/>
<input type="button" name="brown_btn" class="red_btn pop_lec_btn" value="수강신청"/>
</dl>
</div>
<!-- 라이패스 인기강좌 정보 3 끝 -->
<!-- 라이패스 인기강좌 정보 4 시작 -->
<div class="popular_register">
<p><img src="/_template/skin/cs/basic/images/popular_photo4.gif" alt="강사사진"/></p>
<ul class="pop_list">
<li class="pop_list_first"><a href="#"><strong>공인중개사</strong></a><img src="/_template/skin/cs/basic/images/newbl.gif" alt="신규등록"/></li>
<li><span>최우영 교수</span></li>
<li>
<ul class="star">
<li><img src="/_template/skin/cs/basic/images/starO.gif" alt="별점O"/></li>
<li><img src="/_template/skin/cs/basic/images/starO.gif" alt="별점O"/></li>
<li><img src="/_template/skin/cs/basic/images/starO.gif" alt="별점O"/></li>
<li><img src="/_template/skin/cs/basic/images/starO.gif" alt="별점O"/></li>
<li><img src="/_template/skin/cs/basic/images/starO.gif" alt="별점O"/></li>
</ul>
</li>
<input type="button" name="white_btn" class="white_btn pop_lec_btn" value="자세히보기"/>
<input type="button" name="brown_btn" class="red_btn pop_lec_btn" value="수강신청"/>
</dl>
</div>
<!-- 라이패스 인기강좌 정보 4 끝 -->
<!-- 라이패스 인기강좌 정보 5시작 -->
<div class="popular_register">
<p><img src="/_template/skin/cs/basic/images/popular_photo5.gif" alt="강사사진"/></p>
<ul class="pop_list">
<li class="pop_list_first"><a href="#"><strong>예비전력관리 업무담당자</strong></a><img src="/_template/skin/cs/basic/images/newbl.gif" alt="신규등록"/></li>
<li><span>최우영 교수</span></li>
<li>
<ul class="star">
<li><img src="/_template/skin/cs/basic/images/starO.gif" alt="별점O"/></li>
<li><img src="/_template/skin/cs/basic/images/starO.gif" alt="별점O"/></li>
<li><img src="/_template/skin/cs/basic/images/starO.gif" alt="별점O"/></li>
<li><img src="/_template/skin/cs/basic/images/starO.gif" alt="별점O"/></li>
<li><img src="/_template/skin/cs/basic/images/starO.gif" alt="별점O"/></li>
</ul>
</li>
<input type="button" name="white_btn" class="white_btn pop_lec_btn" value="자세히보기"/>
<input type="button" name="brown_btn" class="red_btn pop_lec_btn" value="수강신청"/>
</dl>
</div>
<!-- 라이패스 인기강좌 정보 5 끝 -->
<!-- 라이패스 인기강좌 정보 6 시작 -->
<div class="popular_register">
<p><img src="/_template/skin/cs/basic/images/popular_photo6.gif" alt="강사사진"/></p>
<ul class="pop_list">
<li class="pop_list_first"><a href="#"><strong>기능9급공무원</strong></a><img src="/_template/skin/cs/basic/images/newbl.gif" alt="신규등록"/></li>
<li><span>최우영 교수</span></li>
<li>
<ul class="star">
<li><img src="/_template/skin/cs/basic/images/starO.gif" alt="별점O"/></li>
<li><img src="/_template/skin/cs/basic/images/starO.gif" alt="별점O"/></li>
<li><img src="/_template/skin/cs/basic/images/starO.gif" alt="별점O"/></li>
<li><img src="/_template/skin/cs/basic/images/starO.gif" alt="별점O"/></li>
<li><img src="/_template/skin/cs/basic/images/starX.gif" alt="별점X"/></li>
</ul>
</li>
<input type="button" name="white_btn" class="white_btn pop_lec_btn" value="자세히보기"/>
<input type="button" name="brown_btn" class="red_btn pop_lec_btn" value="수강신청"/>
</dl>
</div>
<!-- 라이패스 인기강좌 정보 6 끝 -->
</div>
<!-- 라이패스 인기강좌 영역 끝 -->
</div>
<!-- 컨텐츠  영역 끝 -->