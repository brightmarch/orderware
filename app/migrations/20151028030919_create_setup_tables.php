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
                item_attribute_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL,
                updated_at timestamp without time zone NOT NULL,
                created_by text NOT NULL,
                updated_by text NOT NULL,
                item_id integer NOT NULL REFERENCES item (item_id) ON DELETE CASCADE,
                attribute text NOT NULL,
                value text NOT NULL,
                CONSTRAINT item_attribute_pkey PRIMARY KEY (item_attribute_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX item_attribute_item_id_idx ON item_attribute (item_id)");
        $this->execute("CREATE UNIQUE INDEX item_attribute_item_id_attribute_idx ON item_attribute (item_id, attribute)");

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
                item_sku_attribute_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL,
                updated_at timestamp without time zone NOT NULL,
                created_by text NOT NULL,
                updated_by text NOT NULL,
                sku_id integer NOT NULL REFERENCES item_sku (sku_id) ON DELETE CASCADE,
                attribute text NOT NULL,
                value text NOT NULL,
                CONSTRAINT item_sku_attribute_pkey PRIMARY KEY (item_sku_attribute_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX item_sku_attribute_sku_id_idx ON item_sku_attribute (sku_id)");
        $this->execute("CREATE UNIQUE INDEX item_sku_attribute_sku_id_attribute_idx ON item_sku_attribute (sku_id, attribute)");


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
            CREATE TABLE inventory (
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
                qty_shipped integer NOT NULL DEFAULT 0,
                qty_onhand integer NOT NULL DEFAULT 0,
                qty_available integer NOT NULL DEFAULT 0,
                CONSTRAINT inventory_pkey PRIMARY KEY (inventory_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX inventory_account_idx ON inventory (account)");
        $this->execute("CREATE INDEX inventory_sku_id_idx ON inventory (sku_id)");
        $this->execute("CREATE INDEX inventory_facility_id_idx ON inventory (facility_id)");
        $this->execute("CREATE UNIQUE INDEX inventory_account_sku_id_facility_id_idx ON inventory (account, sku_id, facility_id)");

        $this->execute("
            CREATE OR REPLACE FUNCTION calculate_inventory_buckets() RETURNS TRIGGER AS $$
            BEGIN
                NEW.qty_onhand = NEW.qty_received - NEW.qty_shipped;
                NEW.qty_available = NEW.qty_received - NEW.qty_ordered;

                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql
        ");

        $this->execute("
            CREATE TRIGGER calculate_inventory_buckets_on_insert_on_update
            BEFORE INSERT OR UPDATE ON inventory
            FOR EACH ROW EXECUTE PROCEDURE calculate_inventory_buckets()
        ");
    }

    public function down()
    {
        $this->execute("DROP TABLE IF EXISTS inventory CASCADE");
        $this->execute("DROP TABLE IF EXISTS item_sku_barcode CASCADE");
        $this->execute("DROP TABLE IF EXISTS item_sku_attribute CASCADE");
        $this->execute("DROP TABLE IF EXISTS item_sku CASCADE");
        $this->execute("DROP TABLE IF EXISTS item_attribute CASCADE");
        $this->execute("DROP TABLE IF EXISTS item CASCADE");
        $this->execute("DROP TABLE IF EXISTS facility CASCADE");
        $this->execute("DROP TABLE IF EXISTS vendor CASCADE");

        $this->execute("DROP TABLE IF EXISTS account CASCADE");
        $this->execute("DROP TABLE IF EXISTS status CASCADE");

        $this->execute("DROP FUNCTION IF EXISTS calculate_inventory_buckets()");
    }

}
