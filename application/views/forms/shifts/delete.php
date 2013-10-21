<?php echo form_open('shifts/delete/'.$shift['id']); ?>
<table>
  <tr>
    <td>Day:</td>
    <td><?php echo $shift['day']; ?></td>
  </tr>
  <tr>
    <td>Time In: </td>
    <td><?php echo $shift['time_in']; ?></td>
  </tr>
  <tr>
    <td>Time Out: </td>
    <td><?php echo $shift['time_out']; ?></td>
  </tr>
  <tr>
    <td><input type="checkbox" value="1" name="confirm" /></td>
    <td>Yes I would like to delete this shift.</td>
  </tr>
</table>
<input type="submit" value="delete shift" />
</form>
