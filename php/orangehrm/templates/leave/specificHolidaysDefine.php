<?php
/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 hSenid Software, http://www.hsenid.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */

/*
 *	Including the language pack
 *
 **/

 $lan = new Language();

 require_once($lan->getLangPath("full.php"));

 if (isset($_GET['message'])) {
?>
<var><?php echo $_GET['message']; ?></var>
<?php } ?>
<h2><?php echo $lang_Leave_Leave_Holiday_Specific_Title; ?><hr/></h2>
<?php
	if (isset($records)) {
		$id = $records[0]->getHolidayId();
		$description = $records[0]->getDescription();
		$date = $records[0]->getDate();
		$recurring = ($records[0]->getRecurring() == Holidays::HOLIDAYS_RECURRING)?"checked":"";
		$length = $records[0]->getLength();
	} else {
		$id = "";
		$description = "";
		$date = "";
		$recurring = "";
		$length = "";
	}

	if (isset($modifier) && $modifier) {
		$action = "Holiday_Specific_Edit";
	} else {
		$action = "Holiday_Specific_Add";
	}
?>
<script>
	function goBack() {
		location.href = '<?php echo $_SERVER['PHP_SELF']; ?>?leavecode=Leave&action=Holiday_Specific_List';
	}

	function addSave() {
		if (validate()) {
			document.frmDefineHolidays.submit();
		}
	}

	function validate() {
		errMes = "";

		obj = $('txtDescription');
		if (obj.value.trim() == "") {
			errMes += "\t- <?php echo $lang_Error_NameOfHolidayCannotBeBlank; ?>\r\n";
		}
		obj = $('txtDate');
		if (!validDate(obj.value.trim())) {
			errMes += "\t- <?php echo $lang_Error_InvalidDate; ?>\r\n";
		}

		if (errMes != "") {
			errMes = "Please correct the following errors to continue\r\n\r\n"+errMes;
			alert(errMes);
			return false;
		} else {
			return true;
		}
	}

	function validDate(txt) {
		dateExpression = /^[0-9]{4}-[0-9]{2}-[0-9]{2}$/

		if (!dateExpression.test(txt)) {
			return false;
		}

		return true;
	}

	function $(id) {
		return document.getElementById(id);
	}

	String.prototype.trim = function () {
		regExp = /^\s+|\s+$/g;
		str = this;
		str = str.replace(regExp, "");

		return str;
	}
</script>
<form id="frmDefineHolidays" name="frmDefineHolidays" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?leavecode=Leave&action=<?php echo $action; ?>">
<p class="navigation">
  	  <input type="image" title="Back" onMouseOut="this.src='../../themes/beyondT/pictures/btn_back.jpg';" onMouseOver="this.src='../../themes/beyondT/pictures/btn_back_02.jpg';"  src="../../themes/beyondT/pictures/btn_back.jpg" onClick="goBack(); return false;">
</p>
<input type="hidden" value="<?php echo $id; ?>" name="txtId" />
<table border="0" cellpadding="0" cellspacing="0">
  <thead>
  	<tr>
		<th class="tableTopLeft"></th>
    	<th class="tableTopMiddle"></th>
    	<th class="tableTopMiddle"></th>
    	<th class="tableTopMiddle"></th>
    	<th class="tableTopMiddle"></th>
		<th class="tableTopRight"></th>
	</tr>
  </thead>
  <tbody>
  <tr>
  	<td class="tableMiddleLeft"></td>
  	<td width="135px"><span class="error">*</span><?php echo $lang_Leave_Common_NameOfHoliday;?></td>
  	<td >&nbsp;</td>
    <td ><input type="text" id="txtDescription" name="txtDescription" size="30" value="<?php echo $description; ?>"/></td>
    <td >&nbsp;</td>
	<td class="tableMiddleRight"></td>
  </tr>
  <tr>
  	<td class="tableMiddleLeft"></td>
  	<td width="135px"><span class="error">*</span><?php echo $lang_Leave_Common_Date;?></td>
  	<td >&nbsp;</td>
    <td ><input name="txtDate" id="txtDate" type="text" value="<?php echo $date; ?>" />
          <input type="button" name="Submit" value="..." onclick="if(self.gfPop)gfPop.fPopCalendar(document.frmDefineHolidays.txtDate); return false;"/></td>
    <td >&nbsp;</td>
	<td class="tableMiddleRight"></td>
  </tr>
  <tr>
  	<td class="tableMiddleLeft"></td>
  	<td width="135px"><?php echo $lang_Leave_Common_Recurring;?></td>
  	<td >&nbsp;</td>
    <td ><input name="chkRecurring" id="chkRecurring" type="checkbox" value="<?php echo Holidays::HOLIDAYS_RECURRING; ?>" <?php echo $recurring; ?> /></td>
    <td >&nbsp;</td>
	<td class="tableMiddleRight"></td>
  </tr>
  <tr>
  	<td class="tableMiddleLeft"></td>
  	<td width="135px"><?php echo $lang_Leave_Common_Length;?></td>
  	<td >&nbsp;</td>
    <td ><select name="sltLeaveLength" id="sltLeaveLength">
            <option value="<?php echo Leave::LEAVE_LENGTH_FULL_DAY; ?>" <?php echo ($length == Leave::LEAVE_LENGTH_FULL_DAY)?"selected":""; ?>><?php echo $lang_Leave_Common_FullDay; ?></option>
            <option value="<?php echo Leave::LEAVE_LENGTH_HALF_DAY;?>" <?php echo ($length == Leave::LEAVE_LENGTH_HALF_DAY)?"selected":""; ?>><?php echo $lang_Leave_Common_HalfDay; ?></option>
         </select>
    </td>
    <td >&nbsp;</td>
	<td class="tableMiddleRight"></td>
  </tr>
  <tr>
  	<td class="tableMiddleLeft"></td>
  	<td >&nbsp;</td>
  	<td >&nbsp;</td>
    <td >&nbsp;</td>
    <td ><img border="0" title="Add" onclick="addSave();" onmouseout="this.src='../../themes/beyondT/pictures/btn_save.jpg';" onmouseover="this.src='../../themes/beyondT/pictures/btn_save_02.jpg';" src="../../themes/beyondT/pictures/btn_save.jpg" /></td>
	<td class="tableMiddleRight"></td>
  </tr>

  </tbody>
  <tfoot>
  	<tr>
		<td class="tableBottomLeft"></td>
		<td class="tableBottomMiddle"></td>
		<td class="tableBottomMiddle"></td>
		<td class="tableBottomMiddle"></td>
		<td class="tableBottomMiddle"></td>
		<td class="tableBottomRight"></td>
	</tr>
  </tfoot>
</table>
</form>
<span id="notice"><?php echo preg_replace('/#star/', '<span class="error">*</span>', $lang_Commn_RequiredFieldMark); ?>.</span>
<iframe width=174 height=189 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../../scripts/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>