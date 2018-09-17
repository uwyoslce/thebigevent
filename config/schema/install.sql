CREATE TABLE conditions
(
    condition_id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    title VARCHAR(50) NOT NULL,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL
);
CREATE TABLE documents
(
    document_id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    path VARCHAR(255) NOT NULL,
    type VARCHAR(50) NOT NULL,
    signed_count INT(11) DEFAULT '0',
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL,
    distributed_count INT(11) DEFAULT '0'
);
CREATE TABLE groups
(
    group_id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    title VARCHAR(50) NOT NULL,
    join_token VARCHAR(12) NOT NULL,
    member_count INT(11) DEFAULT '0',
    participating_member_count INT(11) DEFAULT '0' NOT NULL,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL,
    capacity INT(11) DEFAULT '-1',
    checked_in_member_count INT(11) DEFAULT '0' NOT NULL
);
CREATE TABLE job_assignments
(
    group_id INT(11) NOT NULL,
    job_id INT(11) NOT NULL,
    created DATETIME,
    modified DATETIME,
    CONSTRAINT `PRIMARY` PRIMARY KEY (group_id, job_id)
);
CREATE TABLE jobs
(
    job_id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    contact_first_name VARCHAR(50) NOT NULL,
    contact_last_name VARCHAR(45) NOT NULL,
    contact_phone VARCHAR(45) NOT NULL,
    contact_email VARCHAR(255) NOT NULL,
    contact_address_1 VARCHAR(45) NOT NULL,
    contact_address_2 VARCHAR(45) NOT NULL,
    contact_city VARCHAR(45) NOT NULL,
    contact_state VARCHAR(45) NOT NULL,
    contact_zip VARCHAR(10) NOT NULL,
    contact_best_time_to_call VARCHAR(45) NOT NULL,
    referral VARCHAR(45) NOT NULL,
    job_description LONGTEXT NOT NULL,
    accepted_agreements TINYINT(1) NOT NULL,
    volunteer_count INT(11) DEFAULT '1' NOT NULL,
    todos_incomplete INT(11) DEFAULT '0' NOT NULL,
    todos_complete INT(11) DEFAULT '0' NOT NULL,
    notes TEXT NOT NULL,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL,
    site_leader_id INT(11) DEFAULT '-1' NOT NULL
);
CREATE TABLE jobs_conditions
(
    job_id INT(11) NOT NULL,
    condition_id INT(11) NOT NULL,
    CONSTRAINT `PRIMARY` PRIMARY KEY (job_id, condition_id)
);
CREATE TABLE jobs_tasks
(
    job_id INT(11) NOT NULL,
    task_id INT(11) NOT NULL,
    CONSTRAINT `PRIMARY` PRIMARY KEY (job_id, task_id),
    CONSTRAINT `jt has job` FOREIGN KEY (job_id) REFERENCES jobs (job_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `jt has task` FOREIGN KEY (task_id) REFERENCES tasks (task_id) ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE INDEX `jt has task_idx` ON jobs_tasks (task_id);
CREATE TABLE jobs_tools
(
    job_id INT(11) NOT NULL,
    tool_id INT(11) NOT NULL,
    count INT(11) NOT NULL,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL,
    CONSTRAINT `PRIMARY` PRIMARY KEY (tool_id, job_id)
);
CREATE UNIQUE INDEX unique_pairs ON jobs_tools (job_id, tool_id);
CREATE TABLE membership
(
    group_id INT(11) NOT NULL,
    user_id INT(11) NOT NULL,
    role VARCHAR(50) NOT NULL,
    created DATETIME NOT NULL,
    modified DATETIME,
    CONSTRAINT `PRIMARY` PRIMARY KEY (group_id, user_id)
);
CREATE TABLE meta
(
    meta_id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    model VARCHAR(50) NOT NULL,
    model_id INT(11) NOT NULL,
    meta_key VARCHAR(50) NOT NULL,
    meta_value TEXT,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL
);
CREATE INDEX meta_meta_key_index ON meta (meta_key);
CREATE TABLE phinxlog
(
    version BIGINT(20) PRIMARY KEY NOT NULL,
    migration_name VARCHAR(100),
    start_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    end_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    breakpoint TINYINT(1) DEFAULT '0' NOT NULL
);
CREATE TABLE signatures
(
    signature_id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    document_id INT(11),
    signed TINYINT(1) DEFAULT '0' NOT NULL,
    signature_text VARCHAR(1000) DEFAULT '' NOT NULL,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL
);
CREATE UNIQUE INDEX one_to_one ON signatures (user_id, document_id);
CREATE TABLE tasks
(
    task_id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    title VARCHAR(45) NOT NULL,
    indoor TINYINT(1) NOT NULL,
    outdoor TINYINT(1) NOT NULL,
    created DATETIME NOT NULL,
    modified DATETIME
);
CREATE TABLE todos
(
    todo_id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    model VARCHAR(45) NOT NULL,
    model_id INT(11) NOT NULL,
    description VARCHAR(150) NOT NULL,
    long_description TEXT NOT NULL,
    due DATETIME NOT NULL,
    completed TINYINT(1) NOT NULL,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL
);
CREATE TABLE todos_templates
(
    todo_template_id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    description VARCHAR(45) NOT NULL,
    long_description TEXT NOT NULL,
    due_description VARCHAR(45) NOT NULL,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL
);
CREATE TABLE tools
(
    tool_id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL
);
CREATE TABLE user_identities
(
    user_identity_id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    protocol VARCHAR(45) NOT NULL,
    realm VARCHAR(45) NOT NULL,
    identifier VARCHAR(128) NOT NULL,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL
);
CREATE UNIQUE INDEX user_identities_protocol_realm_identifier_uindex ON user_identities (protocol, realm, identifier);
CREATE TABLE users
(
    user_id INT(10) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) DEFAULT '' NOT NULL,
    role VARCHAR(20) DEFAULT 'participant' NOT NULL,
    first_name VARCHAR(45) DEFAULT '' NOT NULL,
    last_name VARCHAR(45) DEFAULT '' NOT NULL,
    email VARCHAR(255) DEFAULT '' NOT NULL,
    time_zone VARCHAR(45) DEFAULT 'America/Denver' NOT NULL,
    phone VARCHAR(14) DEFAULT '' NOT NULL,
    participating TINYINT(1) DEFAULT '0' NOT NULL,
    checked_in TINYINT(1) DEFAULT '0' NOT NULL,
    todos_incomplete INT(11) DEFAULT '0' NOT NULL,
    todos_complete INT(11) DEFAULT '0' NOT NULL,
    signatures_unsigned INT(11) DEFAULT '0',
    address_1 VARCHAR(100) DEFAULT '' NOT NULL,
    address_2 VARCHAR(100) DEFAULT '',
    city VARCHAR(50) DEFAULT '',
    shirt_size VARCHAR(5) DEFAULT '?',
    state VARCHAR(2) DEFAULT 'WY',
    transportation ENUM('can_drive', 'cannot_drive') DEFAULT 'cannot_drive',
    vehicle_capacity INT(11) DEFAULT '0' NOT NULL,
    zip_code VARCHAR(10) DEFAULT '82071',
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL,
    color VARCHAR(10) DEFAULT '' NOT NULL
);
CREATE TABLE condition_preferences
(
    condition_preference_id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    condition_id INT(11) NOT NULL,
    user_id INT(11) NOT NULL,
    created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    modified DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    preference ENUM('-1', '0', '1') DEFAULT '0' NOT NULL
);
CREATE INDEX conditions_users_condition_id_user_id_index ON condition_preferences (condition_id, user_id);
CREATE UNIQUE INDEX conditions_users_condition_preference_id_uindex ON condition_preferences (condition_preference_id);