CREATE TABLE IF NOT EXISTS `gwork_procedure` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `created_at` INT(11) UNSIGNED NOT NULL,
  `updated_at` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
COMMENT = 'Procedues that generate Process';

CREATE TABLE IF NOT EXISTS `gwork_stage` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `description` VARCHAR(255) NOT NULL DEFAULT '',
  `initial` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'If this state can be the initial stage of a procedure',
  `event_class` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Full name for a php or java class to handle the events',
  `created_at` INT(11) UNSIGNED NOT NULL,
  `updated_at` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
COMMENT = 'Each Procedure has many Stages';

CREATE TABLE IF NOT EXISTS `gwork_stage_assignment` (
  `procedure_id` INT(11) UNSIGNED NOT NULL,
  `stage_id` INT(11) UNSIGNED NOT NULL,
  `created_at` INT(11) UNSIGNED NOT NULL,
  `updated_at` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`procedure_id`, `stage_id`),
  CONSTRAINT `fk_gwork_stage_assignment_procedure`
    FOREIGN KEY (`procedure_id`)
    REFERENCES `gwork_procedure` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_gwork_stage_assignment_stage`
    FOREIGN KEY (`stage_id`)
    REFERENCES `gwork_stage` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
COMMENT = "Assign Stages to Procedures";

CREATE TABLE IF NOT EXISTS `gwork_flow` (
  `procedure_id` INT(11) UNSIGNED NOT NULL,
  `origin_id` INT(11) UNSIGNED NOT NULL,
  `destiny_id` INT(11) UNSIGNED NOT NULL,
  `description` VARCHAR(255) NOT NULL DEFAULT '',
  `created_at` INT(11) UNSIGNED NOT NULL,
  `updated_at` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`procedure_id`, `origin_id`, `destiny_id`),
  INDEX `fk_gwork_flow_origin_idx` (`procedure_id` ASC, `origin_id` ASC),
  INDEX `fk_gwork_flow_destiny_idx` (`procedure_id` ASC, `destiny_id` ASC),
  CONSTRAINT `fk_gwork_flow_origin`
    FOREIGN KEY (`procedure_id` , `origin_id`)
    REFERENCES `gwork_stage_assignment` (`procedure_id` , `stage_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_gwork_flow_destiny`
    FOREIGN KEY (`procedure_id` , `destiny_id`)
    REFERENCES `gwork_stage_assignment` (`procedure_id` , `stage_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
COMMENT = 'The flow from one Stage in a Procedure to another';

CREATE TABLE IF NOT EXISTS `gwork_process` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `procedure_id` INT(11) UNSIGNED NOT NULL,
  `created_by` INT(11) UNSIGNED NOT NULL,
  `updated_by` INT(11) UNSIGNED NOT NULL,
  `description` TEXT NOT NULL,
  `deadline` DATE NULL DEFAULT NULL,
  `created_at` INT(11) UNSIGNED NOT NULL,
  `updated_at` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `procedure_UNIQUE` (`id` ASC, `procedure_id` ASC)  COMMENT 'Used in foreign keys to ensure the process belongs to the procedure',
  INDEX `fk_gwork_process_procedure_stage_idx` (`procedure_id` ASC),
  INDEX `fk_gwork_process_claimant_idx` (`created_by` ASC),
  INDEX `fk_gwork_process_updated_idx` (`updated_by` ASC),
  CONSTRAINT `fk_gwork_process_procedure`
    FOREIGN KEY (`procedure_id`)
    REFERENCES `gwork_procedure` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_gwork_process_created`
    FOREIGN KEY (`created_by`)
    REFERENCES `user` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_gwork_process_updated`
    FOREIGN KEY (`updated_by`)
    REFERENCES `user` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
COMMENT = 'An individual Process member of a Procedure';

CREATE TABLE IF NOT EXISTS `gwork_journal` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `process_id` INT(11) UNSIGNED NOT NULL,
  `procedure_id` INT(11) UNSIGNED NOT NULL,
  `origin_id` INT(11) UNSIGNED NOT NULL,
  `destiny_id` INT(11) UNSIGNED NOT NULL,
  `created_by` INT(11) UNSIGNED NOT NULL,
  `updated_by` INT(11) UNSIGNED NOT NULL,
  `observation` TEXT NOT NULL DEFAULT '',
  `created_at` INT(11) UNSIGNED NOT NULL,
  `updated_at` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_gwork_journal_process_idx` (`process_id` ASC, `procedure_id` ASC),
  INDEX `fk_gwork_journal_flow_idx` (`procedure_id` ASC, `origin_id` ASC, `destiny_id` ASC),
  INDEX `fk_gwork_journal_responsible_idx` (`created_by` ASC),
  INDEX `fk_gwork_journal_updated_idx` (`updated_by` ASC),
  CONSTRAINT `fk_gwork_journal_process`
    FOREIGN KEY (`process_id` , `procedure_id`)
    REFERENCES `gwork_process` (`id` , `procedure_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_gwork_journal_flow`
    FOREIGN KEY (`procedure_id` , `origin_id` , `destiny_id`)
    REFERENCES `gwork_flow` (`procedure_id` , `origin_id` , `destiny_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_gwork_journal_created`
    FOREIGN KEY (`created_by`)
    REFERENCES `user` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_gwork_journal_updated`
    FOREIGN KEY (`updated_by`)
    REFERENCES `user` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
COMMENT = 'The log of stage change of each Process';

CREATE TABLE IF NOT EXISTS `gwork_process_child` (
  `parent_id` INT(11) UNSIGNED NOT NULL,
  `child_id` INT(11) UNSIGNED NOT NULL,
  `created_at` INT(11) UNSIGNED NOT NULL,
  `updated_at` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`parent_id`, `child_id`),
  CONSTRAINT `fk_gwork_process_parent`
    FOREIGN KEY (`parent_id`)
    REFERENCES `gwork_process` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_gwork_process_child`
    FOREIGN KEY (`child_id`)
    REFERENCES `gwork_process` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
COMMENT = 'Parent and Children Process';

CREATE TABLE IF NOT EXISTS `gwork_auth` (
  `stage_id` INT(11) UNSIGNED NOT NULL,
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` INT(11) UNSIGNED NOT NULL,
  `updated_at` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`stage_id`, `item_name`),
  CONSTRAINT `fk_gwork_auth_stage`
    FOREIGN KEY (`stage_id`)
    REFERENCES `gwork_stage` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_gwork_auth_item`
    FOREIGN KEY (`item_name`)
    REFERENCES `auth_item` (`name`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
COMMENT = 'Associate each stage with an AuthItem to validate if a use has the permission assigned to see and edit that stage';
