<div class="control-filters-container-item" >
  <div class="btn-group">
      <select class="form-select selectpicker formControlDefaultFilters" name="output" >
        <option value="100" {% if($_POST['output'] == 100){ echo 'selected=""'; } %} ><?php echo translate("tr_672733d41771a5a6ac2a7d2fb444e493"); ?> 100</option>
        <option value="150" {% if($_POST['output'] == 150){ echo 'selected=""'; } %} ><?php echo translate("tr_672733d41771a5a6ac2a7d2fb444e493"); ?> 150</option>
        <option value="300" {% if($_POST['output'] == 300){ echo 'selected=""'; } %} ><?php echo translate("tr_672733d41771a5a6ac2a7d2fb444e493"); ?> 300</option>
        <option value="500" {% if($_POST['output'] == 500){ echo 'selected=""'; } %} ><?php echo translate("tr_672733d41771a5a6ac2a7d2fb444e493"); ?> 500</option>
        <option value="1000" {% if($_POST['output'] == 1000){ echo 'selected=""'; } %} ><?php echo translate("tr_672733d41771a5a6ac2a7d2fb444e493"); ?> 1000</option>
      </select>
  </div>
</div>