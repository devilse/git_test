function WinPopUP1(jp_url,jp_width,jp_height,jp_name)
{
	var j_env;
	j_env ='status=no, scrollbars=yes, resizable=0,width='+jp_width+',height='+jp_height+'';
	window.open(jp_url,jp_name,j_env);
}