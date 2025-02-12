#
# Add SQL definition of database tables
#

--
-- Table structure for table 'tx_bootstrappackage_timeline_item'
--
CREATE TABLE tx_bootstrappackage_timeline_item (
    sorting int(11) unsigned DEFAULT '0',
    subheader varchar(255) DEFAULT '' NOT NULL,
    datetime date DEFAULT NULL
);

CREATE TABLE tx_bootstrappackage_card_group_item (
    price varchar(255) DEFAULT '' NOT NULL,
);
