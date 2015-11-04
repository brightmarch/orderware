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

                (100, 'Order Open'),
                (110, 'Order Canceled'),
                (120, 'Order Returned'),
                (130, 'Order Closed'),
                (200, 'Order Line Open'),
                (210, 'Order Line Canceled'),
                (220, 'Order Line Returned'),
                (230, 'Order Line Closed'),

                (300, 'Ledger Open'),
                (310, 'Ledger Invoiced'),
                (320, 'Ledger Settled'),

                (400, 'Invoice Open'),
                (410, 'Invoice Settled'),
                (420, 'Invoice Failed'),

                (500, 'Feed Enqueued'),
                (510, 'Feed Processing'),
                (520, 'Feed Processed'),

                (600, 'Item Available'),
                (610, 'Item Unavailable'),

                (1000, 'Lock - Insufficient Payment Authorizations'),
                (1010, 'Lock - Fraudulent Activity')
        ");

        $this->execute("
            CREATE TABLE division (
                division text NOT NULL,
                created_at timestamp without time zone NOT NULL DEFAULT LOCALTIMESTAMP(0),
                updated_at timestamp without time zone NOT NULL DEFAULT LOCALTIMESTAMP(0),
                created_by text NOT NULL,
                updated_by text NOT NULL,
                status_id integer NOT NULL REFERENCES status (status_id),
                display_name text NOT NULL,
                currency text NOT NULL,
                time_zone text NOT NULL,
                primary_email text,
                notification_email text,
                merch_description text,
                CONSTRAINT division_pkey PRIMARY KEY (division),
                CONSTRAINT division_requires_alphanum CHECK (division ~ '^[A-Z0-9]+$')
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX division_status_id_idx ON division (status_id)");

        $this->execute("
            CREATE TABLE feed (
                feed_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL DEFAULT LOCALTIMESTAMP(0),
                updated_at timestamp without time zone NOT NULL DEFAULT LOCALTIMESTAMP(0),
                created_by text NOT NULL,
                updated_by text NOT NULL,
                division text NOT NULL REFERENCES division (division) ON DELETE CASCADE,
                status_id integer NOT NULL REFERENCES status (status_id),
                feed_type text NOT NULL,
                file_name text NOT NULL,
                file_size integer NOT NULL DEFAULT 0,
                file_hash text NOT NULL,
                manifest text,
                feed_body text,
                error_message text,
                has_error boolean NOT NULL DEFAULT false,
                started_at timestamp without time zone,
                finished_at timestamp without time zone,
                run_time integer NOT NULL DEFAULT 0,
                memory_usage integer NOT NULL DEFAULT 0,
                record_count integer NOT NULL DEFAULT 0,
                CONSTRAINT feed_pkey PRIMARY KEY (feed_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX feed_division_idx ON feed (division)");
        $this->execute("CREATE INDEX feed_status_id_idx ON feed (status_id)");
        $this->execute("CREATE INDEX feed_file_name_idx ON feed (file_name)");
        $this->execute("CREATE INDEX feed_has_error_idx ON feed (has_error)");
        $this->execute("CREATE INDEX feed_started_at_idx ON feed (started_at)");
        $this->execute("CREATE INDEX feed_finished_at_idx ON feed (finished_at)");

        $this->execute("
            CREATE TABLE vendor (
                vendor_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL DEFAULT LOCALTIMESTAMP(0),
                updated_at timestamp without time zone NOT NULL DEFAULT LOCALTIMESTAMP(0),
                created_by text NOT NULL,
                updated_by text NOT NULL,
                division text NOT NULL REFERENCES division (division) ON DELETE CASCADE,
                vendor_num text NOT NULL,
                display_name text NOT NULL,
                primary_contact text NOT NULL,
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

        $this->execute("CREATE INDEX vendor_division_idx ON vendor (division)");
        $this->execute("CREATE UNIQUE INDEX vendor_division_vendor_num_idx ON vendor (division, vendor_num)");

        $this->execute("
            CREATE TABLE facility (
                facility_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL DEFAULT LOCALTIMESTAMP(0),
                updated_at timestamp without time zone NOT NULL DEFAULT LOCALTIMESTAMP(0),
                created_by text NOT NULL,
                updated_by text NOT NULL,
                division text NOT NULL REFERENCES division (division) ON DELETE CASCADE,
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

        $this->execute("CREATE INDEX facility_division_idx ON facility (division)");
        $this->execute("CREATE UNIQUE INDEX facility_division_facility_code_idx ON facility (division, facility_code)");
        $this->execute("CREATE UNIQUE INDEX facility_division_is_master_idx ON facility (division, is_master) WHERE is_master = true");

        $this->execute("
            CREATE TABLE item (
                item_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL DEFAULT LOCALTIMESTAMP(0),
                updated_at timestamp without time zone NOT NULL DEFAULT LOCALTIMESTAMP(0),
                created_by text NOT NULL,
                updated_by text NOT NULL,
                division text NOT NULL REFERENCES division (division) ON DELETE CASCADE,
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

        $this->execute("CREATE INDEX item_division_idx ON item (division)");
        $this->execute("CREATE INDEX item_status_id_idx ON item (status_id)");
        $this->execute("CREATE UNIQUE INDEX item_division_item_num_idx ON item (division, item_num)");

        $this->execute("
            CREATE TABLE item_sku (
                sku_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL DEFAULT LOCALTIMESTAMP(0),
                updated_at timestamp without time zone NOT NULL DEFAULT LOCALTIMESTAMP(0),
                created_by text NOT NULL,
                updated_by text NOT NULL,
                division text NOT NULL REFERENCES division (division) ON DELETE CASCADE,
                item_id integer NOT NULL REFERENCES item (item_id) ON DELETE CASCADE,
                status_id integer NOT NULL REFERENCES status (status_id),
                skucode text NOT NULL,
                barcode text NOT NULL,
                cost_price integer NOT NULL DEFAULT 0,
                retail_price integer NOT NULL DEFAULT 0,
                pick_description text NOT NULL,
                CONSTRAINT item_sku_pkey PRIMARY KEY (sku_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX item_sku_division_idx ON item_sku (division)");
        $this->execute("CREATE INDEX item_sku_status_id_idx ON item_sku (status_id)");
        $this->execute("CREATE INDEX item_sku_item_id_barcode_idx ON item_sku (item_id, barcode)");
        $this->execute("CREATE UNIQUE INDEX item_sku_item_id_skucode_idx ON item_sku (item_id, skucode)");

        $this->execute("
            CREATE TABLE inventory (
                inventory_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL DEFAULT LOCALTIMESTAMP(0),
                updated_at timestamp without time zone NOT NULL DEFAULT LOCALTIMESTAMP(0),
                created_by text NOT NULL,
                updated_by text NOT NULL,
                division text NOT NULL REFERENCES division (division) ON DELETE CASCADE,
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

        $this->execute("CREATE INDEX inventory_division_idx ON inventory (division)");
        $this->execute("CREATE INDEX inventory_sku_id_idx ON inventory (sku_id)");
        $this->execute("CREATE INDEX inventory_facility_id_idx ON inventory (facility_id)");
        $this->execute("CREATE UNIQUE INDEX inventory_division_sku_id_facility_id_idx ON inventory (division, sku_id, facility_id)");

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

        $this->execute("
            CREATE TABLE login (
                login_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL DEFAULT LOCALTIMESTAMP(0),
                updated_at timestamp without time zone NOT NULL DEFAULT LOCALTIMESTAMP(0),
                created_by text NOT NULL,
                updated_by text NOT NULL,
                division text REFERENCES division (division) ON DELETE CASCADE,
                status_id integer NOT NULL REFERENCES status (status_id),
                full_name text NOT NULL,
                username text NOT NULL,
                password_hash text NOT NULL,
                time_zone text NOT NULL,
                role text NOT NULL,
                CONSTRAINT login_pkey PRIMARY KEY (login_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX login_division_idx ON login (division)");
        $this->execute("CREATE INDEX login_status_id_idx ON login (status_id)");
        $this->execute("CREATE INDEX login_role_idx ON login (role)");
        $this->execute("CREATE UNIQUE INDEX login_username_idx ON login (username)");

        $this->execute("
            CREATE TABLE request (
                log_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL DEFAULT LOCALTIMESTAMP(0),
                updated_at timestamp without time zone NOT NULL DEFAULT LOCALTIMESTAMP(0),
                created_by text NOT NULL,
                updated_by text NOT NULL,
                division text NOT NULL REFERENCES division (division) ON DELETE CASCADE,
                login_id integer NOT NULL REFERENCES login (login_id) ON DELETE CASCADE,
                request_id text NOT NULL,
                order_num text,
                ip_address text NOT NULL,
                request_method text,
                accept text,
                content_type text,
                user_agent text,
                route_name text,
                parameters json,
                payload text,
                payload_length integer NOT NULL DEFAULT 0,
                payload_hash text,
                status_code integer NOT NULL DEFAULT 0,
                response text,
                response_length integer NOT NULL DEFAULT 0,
                response_hash text,
                start_time bigint NOT NULL DEFAULT 0,
                end_time bigint NOT NULL DEFAULT 0,
                total_time integer NOT NULL DEFAULT 0,
                CONSTRAINT request_pkey PRIMARY KEY (log_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX request_division_idx ON request (division)");
        $this->execute("CREATE INDEX request_login_id_idx ON request (login_id)");
        $this->execute("CREATE INDEX request_order_num_idx ON request (order_num) WHERE order_num IS NOT NULL");
        $this->execute("CREATE INDEX request_ip_address_idx ON request (ip_address)");
        $this->execute("CREATE INDEX request_route_name_idx ON request (route_name)");
        $this->execute("CREATE INDEX request_status_code_idx ON request (status_code)");
        $this->execute("CREATE INDEX request_total_time_idx ON request (total_time)");
        $this->execute("CREATE UNIQUE INDEX request_request_id_idx ON request (request_id)");
    }

    public function down()
    {
        $this->execute("DROP TABLE IF EXISTS request CASCADE");
        $this->execute("DROP TABLE IF EXISTS login CASCADE");

        $this->execute("DROP TABLE IF EXISTS inventory CASCADE");
        $this->execute("DROP TABLE IF EXISTS item_sku CASCADE");
        $this->execute("DROP TABLE IF EXISTS item CASCADE");
        $this->execute("DROP TABLE IF EXISTS facility CASCADE");
        $this->execute("DROP TABLE IF EXISTS vendor CASCADE");

        $this->execute("DROP TABLE IF EXISTS feed CASCADE");

        $this->execute("DROP TABLE IF EXISTS division CASCADE");
        $this->execute("DROP TABLE IF EXISTS status CASCADE");

        $this->execute("DROP FUNCTION IF EXISTS calculate_inventory_buckets()");
    }

}
