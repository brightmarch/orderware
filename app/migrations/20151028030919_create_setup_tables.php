<?php

use Phinx\Migration\AbstractMigration;

class CreateSetupTables extends AbstractMigration
{

    public function up()
    {
        $this->execute("
            CREATE TABLE status (
                status_id integer NOT NULL,
                status_code text NOT NULL,
                CONSTRAINT status_pkey PRIMARY KEY (status_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("
            INSERT INTO status VALUES
                (0, 'Disabled'),
                (1, 'Enabled'),

                (100, 'Feed Queued'),
                (110, 'Feed Processing'),
                (120, 'Feed Completed'),

                (600, 'Item Active'),
                (610, 'Item Inactive')
        ");

        $this->execute("
            CREATE TABLE account (
                account text NOT NULL,
                created_at timestamp without time zone NOT NULL,
                updated_at timestamp without time zone NOT NULL,
                created_by text NOT NULL,
                updated_by text NOT NULL,
                status_id integer NOT NULL REFERENCES status (status_id),
                display_name text NOT NULL,
                currency text NOT NULL,
                time_zone text NOT NULL,
                primary_email text,
                notification_email text,
                merch_description text,
                CONSTRAINT account_pkey PRIMARY KEY (account),
                CONSTRAINT account_requires_alphanum CHECK (account ~ '^[A-Z0-9]+$')
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX account_status_id_idx ON account (status_id)");

        $this->execute("
            CREATE TABLE feed_connection (
                connection_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL,
                updated_at timestamp without time zone NOT NULL,
                created_by text NOT NULL,
                updated_by text NOT NULL,
                type text NOT NULL,
                name text NOT NULL,
                host text,
                username text,
                password text,
                port integer NOT NULL DEFAULT 0,
                private_key text,
                timeout integer NOT NULL DEFAULT 0,
                CONSTRAINT feed_connection_pkey PRIMARY KEY (connection_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX feed_connection_type_idx ON feed_connection (type)");
        $this->execute("CREATE INDEX feed_connection_name_idx ON feed_connection (name)");

        $this->execute("
            CREATE TABLE feed (
                feed_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL,
                updated_at timestamp without time zone NOT NULL,
                created_by text NOT NULL,
                updated_by text NOT NULL,
                account text NOT NULL REFERENCES account (account) ON DELETE CASCADE,
                status_id integer NOT NULL REFERENCES status (status_id),
                connection_id integer REFERENCES feed_connection (connection_id) ON DELETE SET NULL,
                direction text NOT NULL,
                name text NOT NULL,
                service text NOT NULL,
                remote_root_dir text,
                local_root_dir text,
                filename text,
                CONSTRAINT feed_pkey PRIMARY KEY (feed_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX feed_account_idx ON feed (account)");
        $this->execute("CREATE INDEX feed_status_id_idx ON feed (status_id)");
        $this->execute("CREATE INDEX feed_connection_id_idx ON feed (connection_id)");
        $this->execute("CREATE UNIQUE INDEX feed_account_direction_name_idx ON feed (account, direction, name)");

        $this->execute("
            CREATE TABLE feed_attribute (
                attribute_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL,
                updated_at timestamp without time zone NOT NULL,
                created_by text NOT NULL,
                updated_by text NOT NULL,
                feed_id integer NOT NULL REFERENCES feed (feed_id) ON DELETE CASCADE,
                key text NOT NULL,
                value text NOT NULL,
                CONSTRAINT feed_attribute_pkey PRIMARY KEY (attribute_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX feed_attribute_feed_id_idx ON feed_attribute (feed_id)");
        $this->execute("CREATE UNIQUE INDEX feed_attribute_feed_id_key_idx ON feed_attribute (feed_id, key)");

        $this->execute("
            CREATE TABLE feed_log (
                log_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL,
                updated_at timestamp without time zone NOT NULL,
                created_by text NOT NULL,
                updated_by text NOT NULL,
                account text NOT NULL REFERENCES account (account) ON DELETE CASCADE,
                status_id integer NOT NULL REFERENCES status (status_id),
                feed_id integer NOT NULL REFERENCES feed (feed_id) ON DELETE CASCADE,
                runtime integer NOT NULL DEFAULT 0,
                memory_usage integer NOT NULL DEFAULT 0,
                has_error boolean NOT NULL DEFAULT false,
                error_message text,
                error_file_name text,
                error_line_number integer NOT NULL DEFAULT 0,
                CONSTRAINT feed_log_pkey PRIMARY KEY (log_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX feed_log_account_idx ON feed_log (account)");
        $this->execute("CREATE INDEX feed_log_status_id_idx ON feed_log (status_id)");
        $this->execute("CREATE INDEX feed_log_feed_id_idx ON feed_log (feed_id)");

        $this->execute("
            CREATE TABLE feed_log_file (
                file_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL,
                updated_at timestamp without time zone NOT NULL,
                log_id integer NOT NULL REFERENCES feed_log (log_id) ON DELETE CASCADE,
                file_name text NOT NULL,
                file_path text NOT NULL,
                file_size integer NOT NULL DEFAULT 0,
                contents text,
                CONSTRAINT feed_log_file_pkey PRIMARY KEY (file_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX feed_log_file_log_id_idx ON feed_log_file (log_id)");
        $this->execute("CREATE INDEX feed_log_file_file_name_idx ON feed_log_file (file_name)");

        $this->execute("
            CREATE TABLE feed_log_entry (
                entry_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL,
                updated_at timestamp without time zone NOT NULL,
                log_id integer NOT NULL REFERENCES feed_log (log_id) ON DELETE CASCADE,
                is_error boolean NOT NULL DEFAULT false,
                message text NOT NULL,
                CONSTRAINT feed_log_entry_pkey PRIMARY KEY (entry_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX feed_log_entry_log_id_idx ON feed_log_entry (log_id)");

        $this->execute("
            CREATE TABLE vendor (
                vendor_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL,
                updated_at timestamp without time zone NOT NULL,
                created_by text NOT NULL,
                updated_by text NOT NULL,
                account text NOT NULL REFERENCES account (account) ON DELETE CASCADE,
                vendor_num text NOT NULL,
                display_name text NOT NULL,
                primary_contact text NOT NULL,
                account_num text,
                address1 text,
                address2 text,
                city_name text,
                postal_code text,
                state_code text,
                state_name text,
                country_code text,
                country_name text,
                email_address text,
                phone_number text,
                fax_number text,
                notes text,
                CONSTRAINT vendor_pkey PRIMARY KEY (vendor_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX vendor_account_idx ON vendor (account)");
        $this->execute("CREATE UNIQUE INDEX vendor_account_vendor_num_idx ON vendor (account, vendor_num)");

        $this->execute("
            CREATE TABLE facility (
                facility_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL,
                updated_at timestamp without time zone NOT NULL,
                created_by text NOT NULL,
                updated_by text NOT NULL,
                account text NOT NULL REFERENCES account (account) ON DELETE CASCADE,
                facility_code text NOT NULL,
                name text NOT NULL,
                address1 text,
                address2 text,
                city_name text,
                state_name text,
                state_code text,
                postal_code text,
                country_name text,
                country_code text,
                longitude float NOT NULL DEFAULT 0.0,
                latitude float NOT NULL DEFAULT 0.0,
                units_per_day integer NOT NULL DEFAULT 0,
                is_master boolean NOT NULL DEFAULT false,
                CONSTRAINT facility_pkey PRIMARY KEY (facility_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX facility_account_idx ON facility (account)");
        $this->execute("CREATE UNIQUE INDEX facility_account_facility_code_idx ON facility (account, facility_code)");
        $this->execute("CREATE UNIQUE INDEX facility_account_is_master_idx ON facility (account, is_master) WHERE is_master = true");

        $this->execute("
            CREATE TABLE channel (
                channel_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL,
                updated_at timestamp without time zone NOT NULL,
                created_by text NOT NULL,
                updated_by text NOT NULL,
                account text NOT NULL REFERENCES account (account) ON DELETE CASCADE,
                channel_code text NOT NULL,
                name text NOT NULL,
                allocation_percent integer NOT NULL DEFAULT 0,
                is_master boolean NOT NULL DEFAULT false,
                CONSTRAINT channel_pkey PRIMARY KEY (channel_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX channel_account_idx ON channel (account)");
        $this->execute("CREATE UNIQUE INDEX channel_account_channel_code_idx ON channel (account, channel_code)");
        $this->execute("CREATE UNIQUE INDEX channel_account_is_master_idx ON channel (account, is_master) WHERE is_master = true");

        $this->execute("
            CREATE TABLE item (
                item_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL,
                updated_at timestamp without time zone NOT NULL,
                created_by text NOT NULL,
                updated_by text NOT NULL,
                account text NOT NULL REFERENCES account (account) ON DELETE CASCADE,
                status_id integer NOT NULL REFERENCES status (status_id),
                item_num text NOT NULL,
                display_name text NOT NULL,
                weight decimal(12, 4) NOT NULL DEFAULT 0.0,
                length decimal(12, 4) NOT NULL DEFAULT 0.0,
                width decimal(12, 4) NOT NULL DEFAULT 0.0,
                depth decimal(12, 4) NOT NULL DEFAULT 0.0,
                is_ship_alone boolean NOT NULL DEFAULT false,
                is_taxable boolean NOT NULL DEFAULT true,
                is_virtual boolean NOT NULL DEFAULT false,
                track_inventory boolean NOT NULL DEFAULT true,
                CONSTRAINT item_pkey PRIMARY KEY (item_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX item_account_idx ON item (account)");
        $this->execute("CREATE INDEX item_status_id_idx ON item (status_id)");
        $this->execute("CREATE UNIQUE INDEX item_account_item_num_idx ON item (account, item_num)");

        $this->execute("
            CREATE TABLE item_attribute (
                attribute_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL,
                updated_at timestamp without time zone NOT NULL,
                created_by text NOT NULL,
                updated_by text NOT NULL,
                item_id integer NOT NULL REFERENCES item (item_id) ON DELETE CASCADE,
                key text NOT NULL,
                value text NOT NULL,
                CONSTRAINT item_attribute_pkey PRIMARY KEY (attribute_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX item_attribute_item_id_idx ON item_attribute (item_id)");
        $this->execute("CREATE UNIQUE INDEX item_attribute_item_id_key_idx ON item_attribute (item_id, key)");

        $this->execute("
            CREATE TABLE item_sku (
                sku_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL,
                updated_at timestamp without time zone NOT NULL,
                created_by text NOT NULL,
                updated_by text NOT NULL,
                account text NOT NULL REFERENCES account (account) ON DELETE CASCADE,
                item_id integer NOT NULL REFERENCES item (item_id) ON DELETE CASCADE,
                vendor_id integer REFERENCES vendor (vendor_id) ON DELETE SET NULL,
                status_id integer NOT NULL REFERENCES status (status_id),
                skucode text NOT NULL,
                cost_price integer NOT NULL DEFAULT 0,
                retail_price integer NOT NULL DEFAULT 0,
                pick_description text NOT NULL,
                part_number text,
                CONSTRAINT item_sku_pkey PRIMARY KEY (sku_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX item_sku_account_idx ON item_sku (account)");
        $this->execute("CREATE INDEX item_sku_vendor_id_idx ON item_sku (vendor_id)");
        $this->execute("CREATE INDEX item_sku_status_id_idx ON item_sku (status_id)");
        $this->execute("CREATE UNIQUE INDEX item_sku_item_id_skucode_idx ON item_sku (item_id, skucode)");

        $this->execute("
            CREATE TABLE item_sku_attribute (
                attribute_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL,
                updated_at timestamp without time zone NOT NULL,
                created_by text NOT NULL,
                updated_by text NOT NULL,
                sku_id integer NOT NULL REFERENCES item_sku (sku_id) ON DELETE CASCADE,
                key text NOT NULL,
                value text NOT NULL,
                CONSTRAINT item_sku_attribute_pkey PRIMARY KEY (attribute_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX item_sku_attribute_sku_id_idx ON item_sku_attribute (sku_id)");
        $this->execute("CREATE UNIQUE INDEX item_sku_attribute_sku_id_key_idx ON item_sku_attribute (sku_id, key)");

        $this->execute("
            CREATE TABLE item_sku_barcode (
                barcode_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL,
                updated_at timestamp without time zone NOT NULL,
                created_by text NOT NULL,
                updated_by text NOT NULL,
                account text NOT NULL REFERENCES account (account) ON DELETE CASCADE,
                sku_id integer NOT NULL REFERENCES item_sku (sku_id) ON DELETE CASCADE,
                barcode text NOT NULL,
                CONSTRAINT item_sku_barcode_pkey PRIMARY KEY (barcode_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX item_sku_barcode_sku_id_idx ON item_sku_barcode (sku_id)");
        $this->execute("CREATE INDEX item_sku_barcode_barcode_idx ON item_sku_barcode (barcode)");
        $this->execute("CREATE UNIQUE INDEX item_sku_barcode_account_barcode_idx ON item_sku_barcode (account, barcode)");

        $this->execute("
            CREATE TABLE master_inventory (
                inventory_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL,
                updated_at timestamp without time zone NOT NULL,
                created_by text NOT NULL,
                updated_by text NOT NULL,
                account text NOT NULL REFERENCES account (account) ON DELETE CASCADE,
                sku_id integer NOT NULL REFERENCES item_sku (sku_id) ON DELETE CASCADE,
                qty_received integer NOT NULL DEFAULT 0,
                qty_ordered integer NOT NULL DEFAULT 0,
                qty_canceled integer NOT NULL DEFAULT 0,
                qty_shipped integer NOT NULL DEFAULT 0,
                qty_onhand integer NOT NULL DEFAULT 0,
                qty_available integer NOT NULL DEFAULT 0,
                CONSTRAINT master_inventory_pkey PRIMARY KEY (inventory_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX master_inventory_account_idx ON master_inventory (account)");
        $this->execute("CREATE INDEX master_inventory_sku_id_idx ON master_inventory (sku_id)");
        $this->execute("CREATE UNIQUE INDEX master_inventory_account_sku_id_idx ON master_inventory (account, sku_id)");

        $this->execute("
            CREATE TABLE reserved_inventory (
                inventory_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL,
                updated_at timestamp without time zone NOT NULL,
                created_by text NOT NULL,
                updated_by text NOT NULL,
                account text NOT NULL REFERENCES account (account) ON DELETE CASCADE,
                sku_id integer NOT NULL REFERENCES item_sku (sku_id) ON DELETE CASCADE,
                facility_id integer NOT NULL REFERENCES facility (facility_id) ON DELETE CASCADE,
                qty_received integer NOT NULL DEFAULT 0,
                qty_ordered integer NOT NULL DEFAULT 0,
                qty_canceled integer NOT NULL DEFAULT 0,
                qty_shipped integer NOT NULL DEFAULT 0,
                qty_onhand integer NOT NULL DEFAULT 0,
                qty_available integer NOT NULL DEFAULT 0,
                CONSTRAINT reserved_inventory_pkey PRIMARY KEY (inventory_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX reserved_inventory_account_idx ON reserved_inventory (account)");
        $this->execute("CREATE INDEX reserved_inventory_sku_id_idx ON reserved_inventory (sku_id)");
        $this->execute("CREATE INDEX reserved_inventory_facility_id_idx ON reserved_inventory (facility_id)");
        $this->execute("CREATE UNIQUE INDEX reserved_inventory_account_sku_id_facility_id_idx ON reserved_inventory (account, sku_id, facility_id)");

        $this->execute("
            CREATE OR REPLACE FUNCTION calculate_inventory_buckets() RETURNS TRIGGER AS $$
            BEGIN
                NEW.qty_onhand = NEW.qty_received - NEW.qty_shipped;
                NEW.qty_available = NEW.qty_received - NEW.qty_ordered - NEW.qty_canceled;

                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql
        ");

        $this->execute("
            CREATE OR REPLACE FUNCTION sync_received_units() RETURNS TRIGGER AS $$
            BEGIN
                UPDATE master_inventory SET qty_received = NEW.qty_received WHERE sku_id = NEW.sku_id;

                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql
        ");

        $this->execute("
            CREATE TRIGGER calculate_master_inventory_buckets_on_insert_on_update
            BEFORE INSERT OR UPDATE ON master_inventory
            FOR EACH ROW EXECUTE PROCEDURE calculate_inventory_buckets()
        ");

        $this->execute("
            CREATE TRIGGER calculate_reserved_inventory_buckets_on_insert_on_update
            BEFORE INSERT OR UPDATE ON reserved_inventory
            FOR EACH ROW EXECUTE PROCEDURE calculate_inventory_buckets()
        ");

        $this->execute("
            CREATE TRIGGER sync_received_units_on_insert_on_update
            BEFORE INSERT OR UPDATE ON reserved_inventory
            FOR EACH ROW EXECUTE PROCEDURE sync_received_units()
        ");
    }

    public function down()
    {
        $this->execute("DROP TABLE IF EXISTS reserved_inventory CASCADE");
        $this->execute("DROP TABLE IF EXISTS master_inventory CASCADE");

        $this->execute("DROP TABLE IF EXISTS item_sku_barcode CASCADE");
        $this->execute("DROP TABLE IF EXISTS item_sku_attribute CASCADE");
        $this->execute("DROP TABLE IF EXISTS item_sku CASCADE");
        $this->execute("DROP TABLE IF EXISTS item_attribute CASCADE");
        $this->execute("DROP TABLE IF EXISTS item CASCADE");
        $this->execute("DROP TABLE IF EXISTS channel CASCADE");
        $this->execute("DROP TABLE IF EXISTS facility CASCADE");
        $this->execute("DROP TABLE IF EXISTS vendor CASCADE");

        $this->execute("DROP TABLE IF EXISTS feed_log_entry CASCADE");
        $this->execute("DROP TABLE IF EXISTS feed_log_file CASCADE");
        $this->execute("DROP TABLE IF EXISTS feed_log CASCADE");
        $this->execute("DROP TABLE IF EXISTS feed_attribute CASCADE");
        $this->execute("DROP TABLE IF EXISTS feed CASCADE");
        $this->execute("DROP TABLE IF EXISTS feed_connection CASCADE");

        $this->execute("DROP TABLE IF EXISTS account CASCADE");
        $this->execute("DROP TABLE IF EXISTS status CASCADE");

        $this->execute("DROP FUNCTION IF EXISTS calculate_inventory_buckets()");
        $this->execute("DROP FUNCTION IF EXISTS sync_received_units()");
    }

}
