<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><!--web_title--> - 后台管理</title>
<meta http-equiv="Pragma" contect="no-cache">
<meta http-equiv="Expires" contect="-1">
<meta http-equiv="windows-Target" contect="_top">
<meta http-equiv="Content-Type" content="text/html; charset=<!--charset-->" />
<link rel="stylesheet" type="text/css" media="all" href="../../<!--path_admin-->/style.css" />
<script language="JavaScript" src="../../script/jquery.js"></script>
<script language="JavaScript" src="../../script/jquery.addon.js"></script>
<script language="JavaScript" src="../../script/global.js"></script>
<script language="JavaScript" src="../../script/admin.js"></script>
<script language="JavaScript" src="../../script/addon.js"></script>
</head>
<body>
<div id="page_ole">
	<div id="page_main">
<div class="title"><!--title--></div>
<div align="center">
	<script type="text/javascript" src="../../script/checkForm.js" Language="JavaScript1.2"></script>
	<script type="text/javascript" src="../../script/jquery.date_input.js" Language="JavaScript1.2"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0">
			<tr>
				<td class="cat" width="80">任务名称：</td>
				<td class="row">
					<input name="name" type="text" value="<!--name-->" maxlength="120" need="" />
					<input type="hidden" name="id" value="<!--id-->" />
				</td>
			</tr>
			<tr>
				<td class="cat">计时模式：</td>
				<td class="row">
					<select name="mode" onchange="showSchedule()">
						<option value="0">按一定频率</option>
						<option value="1">按一定时间</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="cat">执行计划：</td>
				<td class="row">
					<select name="schedule[]" style="width:40px;" onchange="showSchedule()">
						<option value="0"></option>
						<option>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
						<option>5</option>
						<option>6</option>
						<option>7</option>
						<option>8</option>
						<option>9</option>
						<option>10</option>
						<option>11</option>
						<option>12</option>
					</select> 月
					<select name="schedule[]" style="width:40px;" onchange="showSchedule()">
						<option value="0"></option>
						<option>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
						<option>5</option>
						<option>6</option>
						<option>7</option>
						<option>8</option>
						<option>9</option>
						<option>10</option>
						<option>11</option>
						<option>12</option>
						<option>13</option>
						<option>14</option>
						<option>15</option>
						<option>16</option>
						<option>17</option>
						<option>18</option>
						<option>19</option>
						<option>20</option>
						<option>21</option>
						<option>22</option>
						<option>23</option>
						<option>24</option>
						<option>25</option>
						<option>26</option>
						<option>27</option>
						<option>28</option>
						<option>29</option>
						<option>30</option>
						<option>31</option>
					</select> 日
					<select name="schedule[]" style="width:40px;" onchange="showSchedule()">
						<option value="0"></option>
						<option>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
						<option>5</option>
						<option>6</option>
						<option>7</option>
						<option>8</option>
						<option>9</option>
						<option>10</option>
						<option>11</option>
						<option>12</option>
						<option>13</option>
						<option>14</option>
						<option>15</option>
						<option>16</option>
						<option>17</option>
						<option>18</option>
						<option>19</option>
						<option>20</option>
						<option>21</option>
						<option>22</option>
						<option>23</option>
						<option>24</option>
					</select> 时
					<select name="schedule[]" style="width:40px;" onchange="showSchedule()">
						<option value="0"></option>
						<option>5</option>
						<option>10</option>
						<option>15</option>
						<option>20</option>
						<option>25</option>
						<option>30</option>
						<option>35</option>
						<option>40</option>
						<option>45</option>
						<option>50</option>
						<option>55</option>
						<option>60</option>
					</select> 分
					（周
					<select name="schedule[]" style="width:40px;" onchange="showSchedule()">
						<option value="0"></option>
						<option>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
						<option>5</option>
						<option>6</option>
						<option>7</option>
					</select> ）
					（<span id="schedule_info">请选择</span>）
					<input type="hidden" name="describe" value="<!--describe-->" />
				</td>
			</tr>
			<tr>
				<td class="cat">过期时间：</td>
				<td class="row">
					<input name="expire" type="text" value="<!--expire-->" maxlength="120" need="date_" />
				</td>
			</tr>
			<tr>
				<td class="cat">连接网址：</td>
				<td class="row">
					<input name="url" type="text" value="<!--url-->" maxlength="120" need="url_" />
				</td>
			</tr>
			<tr>
				<td class="cat">执行代码：</td>
				<td class="row">
					<textarea name="code" style="width:100%;height:200px;" /><!--code--></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input class="btn" type="Submit" value=" 提 交 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回 " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>
	</div>
</div>
</body>
<script language="JavaScript">
function showSchedule() {
	var result = "";
	var mode = $("select[name=mode]").val();
	var schedule = $name("schedule[]");
	if(mode==1) {
		if(schedule[4].value==0) {
			if(schedule[0].value==0) {
				result += "每月，";
			} else {
				result += "每年 "+schedule[0].value+"月，";
			}
			if(schedule[1].value==0) {
				result += "每日，";
			} else {
				result += schedule[1].value+"日，";
			}
		} else {
			result += "每周"+schedule[4].value+"，";
		}
		if(schedule[2].value==0) {
			result += "每小时，";
		} else {
			result += schedule[2].value+"点，";
		}
		if(schedule[3].value==0) {
			result += "0分";
		} else {
			result += schedule[3].value+"分，";
		}
	} else {
		result = "每隔 ";
		if(schedule[4].value==0) {
			if(schedule[0].value!=0) {
				result += schedule[0].value+"月，";
			}
			if(schedule[1].value!=0) {
				result += schedule[1].value+"日，";
			}
			if(schedule[2].value!=0) {
				result += schedule[2].value+"小时，";
			}
			if(schedule[3].value!=0) {
				result += schedule[3].value+"分钟，";
			} else {
				result += "10分钟，";
			}
		} else {
			result += schedule[4].value+"周，";
		}
	}
	result += "执行计划任务";
	$("#schedule_info").text(result);
	$("input[name=describe]").val(result);
	return;
}
$(function(){
	var schedule = ("<!--schedule-->").split(",");
	var schedule_obj = $name("schedule[]");
	for(var i=0; i<schedule_obj.length; i++) {
		$(schedule_obj[i]).val(schedule[i]);
	}
	$("select[name=mode]").val("<!--mode-->");
	if($("input[name=expire]").val()=="0000-00-00") $("input[name=expire]").val("");
	showSchedule();
});
</script>
</html>