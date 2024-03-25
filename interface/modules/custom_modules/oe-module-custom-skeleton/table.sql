-- This table definition is loaded and then executed when the OpenEMR interface's install button is clicked.
CREATE TABLE IF NOT EXISTS `mod_custom_skeleton_records`(
    `id` INT(11)  PRIMARY KEY AUTO_INCREMENT NOT NULL
    ,`name` VARCHAR(255) NOT NULL
);


-- INSERT INTO layout_group_properties  (grp_form_id,grp_group_id,grp_title) values ('DEM','extra',"Extra Data");
-- INSERT INTO layout_options (form_id, field_id, group_id, title, seq, data_type, uor, fld_length, max_length, titlecols, datacols, default_value, edit_options, description, fld_rows, source)
-- VALUES ('DEM', 'extra_data2', 'extra', 'Extra Data2', 12, 2, 1, 20, 60, 1, 1, '', '', '', 60, 'F'),('DEM', 'extra_data0', 'extra', 'Extra Data0', 10, 2, 1, 20, 60, 1, 1, '', '', '', 60, 'F'),('DEM', 'extra_data1', 'extra', 'Extra Data1', 11, 2, 1, 20, 60, 1, 1, '', '', '', 60, 'F');

-- ALTER TABLE `patient_data`
--   ADD `extra_data0` TEXT,
--   ADD `extra_data1` TEXT,
--   ADD `extra_data2` TEXT;
