<script type="text/javascript" src="/_js/jquery.min.js"></script>
<script type="text/javascript">
	$(function() {
		$(".td_disable").append("<div class=\"td_blind\"></div>");
	});
</script>

<style type="text/css">
.stateMsg { float:right; background-color: #FF0000; color: #FFFFFF; padding-left:3px; padding-right:3px; }

.refundMsg_card { background-color: #0054FF; color: #FFFFFF; padding:3px; }
.refundMsg_bank { background-color: #5F00FF; color: #FFFFFF; padding:3px; }
.title_head { background-color: #5F00FF; color: #FFFFFF; padding:3px; }

.td_disable { position: relative; }
.td_blind { 
	position: absolute; left: 0px; top: 0px; width: 100%; height: 100%; background-color: gray; 
	filter: alpha(opacity=50); -khtml-opacity:0.5; -moz-opacity: 0.5; opacity: 0.5;
}

.no_line { border-width: 0px; }
</style>
<div class="divtitle">
	환불 관리
</div>
<br />
<table class="optiontable">
	<caption>01. 신청정보</caption>
	<tr>
		<td class="title">주문번호</td>
		<td>20120705135012214735</td>
		<td class="title">환불신청일</td>
		<td>2012.10.19</td>
	</tr>
	<tr>
		<td class="title">주문자</td>
		<td>nut999(이정현)</td>
		<td class="title">결제일</td>
		<td>2012.09.19 신용카드</td>
	</tr>
	<tr>
		<td class="title">연락처</td>
		<td>010-2244-1915</td>
		<td class="title">이메일</td>
		<td>nut999@naver.com</td>
	</tr>
	<tr>
		<td class="title">환불계좌</td>
		<td colspan="3">예금주:이정현 우리은행 123456789123</td>		
	</tr>
	<tr>
		<td class="title">주문목록</td>
		<td colspan="3">
			<table class="listtable">
				<tr>
					<th>상품</th>
					<th>가격</th>
					<th>비고</th>
				</tr>
				<tr>
					<td><span class="title_head">강의</span> 동영상 강의1</td>
					<td>150,000</td>
					<td>전체 30강 / 15강 수강함</td>
				</tr>
				<tr>					
					<td><span class="title_head">교재</span> 교재1</td>
					<td>250,000</td>
					<td>배송대기중</td>
				</tr>
			</table>
		</td>		
	</tr>
	<tr>
		<td class="title">전체 결제금액</td>
		<td colspan="3">150,000</td>		
	</tr>
	<tr>
		<td class="title">환불사유</td>
		<td colspan="3">환불 사유입니다.</td>		
	</tr>
</table>
<br />
<table class="optiontable">
	<caption>02. 환불 처리하기</caption>
	<tr>
		<td class="title">01. 접수</td>
		<td><span>고객의 신청 정보를 충분히 확인, 숙지 하셨습니까? <input type="button" value="확인" /></span><span class="stateMsg">접수완료</span></td>
	</tr>
	<tr>
		<td class="title">02. 상담</td>
		<td class="td_disable"><span>고객과 상담하여 충분한 협의가 이루어졌습니다. <input type="button" value="확인" /> <input type="button" value="환불취소" /></span><span class="stateMsg">환불처리중</span></td>
	</tr>
	<tr>
		<td class="title">03. 최종환불금</td>
		<td class="td_disable"><span><input type="text" /> <input type="button" value="입력" /></span><span class="stateMsg">환불처리중</span></td>
	</tr>
	<tr>
		<td class="title">04. 입금</td>
		<td class="td_disable"><span>카드 취소 또는 고객의 계좌로 입금이 완료되었습니다. <input type="button" value="카드취소" /> <input type="button" value="현금환불" /></span><span class="stateMsg">환불처리완료</span></td>
	</tr>
	<tr>
		<td class="title">관리자 메모</td>
		<td><span><textarea style="width:80%; height:100px;"></textarea> <input type="button" value="메모 저장" /></span></td>
	</tr>
	<tr>
		<td class="title">환불 완료일</td>
		<td class="td_disable"><span>2012.12.15</span> <span class="refundMsg_card">카드취소</span> <span class="refundMsg_bank">현금환불</span></td>
	</tr>
	<tr>
		<td class="title">최종 환불금액</td>
		<td class="td_disable"><span>90,000</span></td>
	</tr>
</table>
<br />
<div class="divbutton">
<a href="index.php?mode=refund">목록으로</a>
</div>