<?php

use Phinx\Migration\AbstractMigration;

class CreateOrderTables extends AbstractMigration
{

    public function up()
    {
        $this->execute("
            CREATE TABLE ord_header (
                ord_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL,
                updated_at timestamp without time zone NOT NULL,
                created_by text NOT NULL,
                updated_by text NOT NULL,
                division text NOT NULL REFERENCES division (division) ON DELETE CASCADE,
                status_id integer NOT NULL REFERENCES status (status_id),
                ordered_at timestamp without time zone NOT NULL,
                order_date date NOT NULL,
                source_code text NOT NULL,
                order_type text NOT NULL,
                order_num text NOT NULL,
                currency text NOT NULL,
                time_zone text NOT NULL,
                line_amount integer NOT NULL DEFAULT 0,
                line_tax_amount integer NOT NULL DEFAULT 0,
                line_local_tax_amount integer NOT NULL DEFAULT 0,
                line_county_tax_amount integer NOT NULL DEFAULT 0,
                line_state_tax_amount integer NOT NULL DEFAULT 0,
                shipping_amount integer NOT NULL DEFAULT 0,
                shipping_tax_amount integer NOT NULL DEFAULT 0,
                shipping_local_tax_amount integer NOT NULL DEFAULT 0,
                shipping_county_tax_amount integer NOT NULL DEFAULT 0,
                shipping_state_tax_amount integer NOT NULL DEFAULT 0,
                discount_amount integer NOT NULL DEFAULT 0,
                order_amount integer NOT NULL DEFAULT 0,
                is_virtual boolean NOT NULL DEFAULT false,
                salesperson text,
                ip_address text,
                customer_notes text,
                store_notes text,
                CONSTRAINT ord_header_pkey PRIMARY KEY (ord_id),
                CONSTRAINT order_num_requires_alphanum CHECK (order_num ~ '^[A-Z0-9]+$')
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX ord_header_division_idx ON ord_header (division)");
        $this->execute("CREATE INDEX ord_header_status_id_idx ON ord_header (status_id)");
        $this->execute("CREATE INDEX ord_header_order_date_idx ON ord_header (order_date)");
        $this->execute("CREATE INDEX ord_header_source_code_idx ON ord_header (source_code)");
        $this->execute("CREATE INDEX ord_header_order_type_idx ON ord_header (order_type)");
        $this->execute("CREATE INDEX ord_header_is_virtual_idx ON ord_header (is_virtual)");
        $this->execute("CREATE UNIQUE INDEX ord_header_division_order_num_idx ON ord_header (division, order_num)");

        $this->execute("
            CREATE TABLE ord_ship (
                ord_ship_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL,
                updated_at timestamp without time zone NOT NULL,
                created_by text NOT NULL,
                updated_by text NOT NULL,
                division text NOT NULL REFERENCES division (division) ON DELETE CASCADE,
                ord_id integer NOT NULL REFERENCES ord_header (ord_id) ON DELETE CASCADE,
                ship_method text NOT NULL,
                first_name text,
                middle_name text,
                last_name text,
                full_name text,
                address1 text,
                address2 text,
                city_name text,
                state_name text,
                state_code text,
                postal_code text,
                country_name text,
                country_code text,
                company_name text,
                email_address text,
                phone_number text,
                notify_by text NOT NULL,
                notification_enabled boolean NOT NULL DEFAULT true,
                facility_code text,
                CONSTRAINT ord_ship_pkey PRIMARY KEY (ord_ship_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX ord_ship_division_idx ON ord_ship (division)");
        $this->execute("CREATE INDEX ord_ship_ord_id_idx ON ord_ship (ord_id)");
        $this->execute("CREATE INDEX ord_ship_ship_method_idx ON ord_ship (ship_method)");

        $this->execute("
            CREATE TABLE ord_line (
                ord_line_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL,
                updated_at timestamp without time zone NOT NULL,
                created_by text NOT NULL,
                updated_by text NOT NULL,
                division text NOT NULL REFERENCES division (division) ON DELETE CASCADE,
                ord_id integer NOT NULL REFERENCES ord_header (ord_id) ON DELETE CASCADE,
                ord_ship_id integer NOT NULL REFERENCES ord_ship (ord_ship_id) ON DELETE CASCADE,
                item_id integer NOT NULL REFERENCES item (item_id) ON DELETE CASCADE,
                sku_id integer NOT NULL REFERENCES item_sku (sku_id) ON DELETE CASCADE,
                facility_id integer REFERENCES facility (facility_id) ON DELETE SET NULL,
                status_id integer NOT NULL REFERENCES status (status_id),
                line_num text NOT NULL,
                item_num text NOT NULL,
                item_name text NOT NULL,
                skucode text NOT NULL,
                pick_description text NOT NULL,
                retail_amount integer NOT NULL DEFAULT 0,
                discount_amount integer NOT NULL DEFAULT 0,
                tax_amount integer NOT NULL DEFAULT 0,
                local_tax_amount integer NOT NULL DEFAULT 0,
                county_tax_amount integer NOT NULL DEFAULT 0,
                state_tax_amount integer NOT NULL DEFAULT 0,
                qty_ordered integer NOT NULL DEFAULT 0,
                qty_available integer NOT NULL DEFAULT 0,
                qty_canceled integer NOT NULL DEFAULT 0,
                qty_backordered integer NOT NULL DEFAULT 0,
                qty_allocated integer NOT NULL DEFAULT 0,
                qty_reserved integer NOT NULL DEFAULT 0,
                qty_picked integer NOT NULL DEFAULT 0,
                qty_shipped integer NOT NULL DEFAULT 0,
                qty_returned integer NOT NULL DEFAULT 0,
                CONSTRAINT ord_line_pkey PRIMARY KEY (ord_line_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX ord_line_division_idx ON ord_line (division)");
        $this->execute("CREATE INDEX ord_line_ord_id_idx ON ord_line (ord_id)");
        $this->execute("CREATE INDEX ord_line_ord_ship_id_idx ON ord_line (ord_ship_id)");
        $this->execute("CREATE INDEX ord_line_item_id_idx ON ord_line (item_id)");
        $this->execute("CREATE INDEX ord_line_sku_id_idx ON ord_line (sku_id)");
        $this->execute("CREATE INDEX ord_line_status_id_idx ON ord_line (status_id)");
        $this->execute("CREATE INDEX ord_line_item_num_idx ON ord_line (item_num)");
        $this->execute("CREATE INDEX ord_line_skucode_idx ON ord_line (skucode)");
        $this->execute("CREATE INDEX ord_line_qty_ordered_idx ON ord_line (qty_ordered)");
        $this->execute("CREATE INDEX ord_line_qty_available_idx ON ord_line (qty_available)");
        $this->execute("CREATE INDEX ord_line_qty_shipped_idx ON ord_line (qty_shipped)");
        $this->execute("CREATE UNIQUE INDEX ord_line_ord_id_line_num_idx ON ord_line (ord_id, line_num)");

        $this->execute("
            CREATE OR REPLACE FUNCTION calculate_ord_line_buckets() RETURNS TRIGGER AS $$
            BEGIN
                NEW.qty_backordered = NEW.qty_ordered - NEW.qty_canceled
                    - NEW.qty_allocated - NEW.qty_reserved
                    - NEW.qty_picked - NEW.qty_shipped;

                NEW.qty_available = NEW.qty_ordered - NEW.qty_canceled;

                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql
        ");

        $this->execute("
            CREATE TRIGGER calculate_ord_line_buckets_on_insert_on_update
            BEFORE INSERT OR UPDATE ON ord_line
            FOR EACH ROW EXECUTE PROCEDURE calculate_ord_line_buckets()
        ");

        $this->execute("
            CREATE TABLE ord_pay (
                ord_pay_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL,
                updated_at timestamp without time zone NOT NULL,
                created_by text NOT NULL,
                updated_by text NOT NULL,
                division text NOT NULL REFERENCES division (division) ON DELETE CASCADE,
                ord_id integer NOT NULL REFERENCES ord_header (ord_id) ON DELETE CASCADE,
                pay_method text NOT NULL,
                authed_amount integer NOT NULL DEFAULT 0,
                transaction_code text NOT NULL,
                currency text NOT NULL,
                CONSTRAINT ord_pay_pkey PRIMARY KEY (ord_pay_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX ord_pay_division_idx ON ord_pay (division)");
        $this->execute("CREATE INDEX ord_pay_ord_id_idx ON ord_pay (ord_id)");
        $this->execute("CREATE INDEX ord_pay_pay_method_idx ON ord_pay (pay_method)");

        $this->execute("
            CREATE TABLE ord_lock (
                ord_lock_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL,
                updated_at timestamp without time zone NOT NULL,
                created_by text NOT NULL,
                updated_by text NOT NULL,
                division text NOT NULL REFERENCES division (division) ON DELETE CASCADE,
                ord_id integer NOT NULL REFERENCES ord_header (ord_id) ON DELETE CASCADE,
                status_id integer NOT NULL REFERENCES status (status_id),
                lock_reason text,
                removed_at timestamp without time zone,
                CONSTRAINT ord_lock_pkey PRIMARY KEY (ord_lock_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX ord_lock_division_idx ON ord_lock (division)");
        $this->execute("CREATE INDEX ord_lock_ord_id_idx ON ord_lock (ord_id)");
        $this->execute("CREATE INDEX ord_lock_status_id_idx ON ord_lock (status_id)");
        $this->execute("CREATE UNIQUE INDEX ord_lock_ord_id_status_id_idx ON ord_lock (ord_id, status_id) WHERE removed_at IS NULL");

        $this->execute("
            CREATE OR REPLACE FUNCTION lock_order(_ord_id integer, _status_id integer, _reason text) RETURNS boolean AS $$
            DECLARE
                _order RECORD;
                _status RECORD;
                _lock RECORD;
            BEGIN
                SELECT INTO _order FROM ord_header oh
                WHERE oh.ord_id = _ord_id;

                IF NOT FOUND THEN
                    RAISE EXCEPTION 'order (%) does not exist', _ord_id;
                END IF;

                SELECT INTO _status FROM status s
                WHERE s.status_id = _status_id;

                IF NOT FOUND THEN
                    RAISE EXCEPTION 'lock status (%) does not exist', _status_id;
                END IF;

                SELECT INTO _lock FROM ord_lock ol
                WHERE ol.ord_id = _ord_id
                    AND ol.status_id = _status_id
                    AND ol.removed_at IS NULL;

                IF FOUND THEN
                    RAISE EXCEPTION 'order (%) is already locked by status (%)', _ord_id, _status_id;
                END IF;

                INSERT INTO ord_lock (
                    created_by, updated_by, division,
                    ord_id, status_id, lock_reason
                ) SELECT 'lock_order', 'lock_order',
                    oh.division, oh.ord_id, _status_id, _reason
                FROM ord_header oh
                WHERE oh.ord_id = _ord_id;

                RETURN TRUE;
            END;
            $$ LANGUAGE plpgsql
        ");

        $this->execute("
            CREATE OR REPLACE FUNCTION unlock_order(_ord_id integer, _status_id integer) RETURNS boolean AS $$
            BEGIN
                UPDATE ord_lock SET updated_at = LOCALTIMESTAMP(0),
                    updated_by = 'unlock_order',
                    removed_at = LOCALTIMESTAMP(0)
                WHERE ord_id = _ord_id
                    AND status_id = _status_id
                    AND removed_at IS NULL;

                RETURN TRUE;
            END;
            $$ LANGUAGE plpgsql
        ");

        $this->execute("
            CREATE OR REPLACE FUNCTION lookup_order(_division text, _order_num text) RETURNS integer AS $$
            DECLARE
                _ord_id integer;
            BEGIN
                SELECT INTO _ord_id oh.ord_id
                FROM ord_header oh
                WHERE oh.division = UPPER(_division)
                    AND oh.order_num = UPPER(_order_num);

                IF FOUND THEN
                    RETURN _ord_id;
                END IF;

                RETURN 0;
            END;
            $$ LANGUAGE plpgsql
        ");

        $this->execute("
            CREATE OR REPLACE FUNCTION calculate_order(_ord_id integer) RETURNS boolean AS $$
            DECLARE
                _order RECORD;
            BEGIN
                SELECT INTO _order oh.ord_id
                FROM ord_header oh
                WHERE oh.ord_id = _ord_id;

                IF NOT FOUND THEN
                    RETURN FALSE;
                END IF;

                UPDATE ord_line SET tax_amount = local_tax_amount +
                    county_tax_amount + state_tax_amount
                WHERE ord_id = _ord_id;

                UPDATE ord_header SET shipping_tax_amount = shipping_local_tax_amount +
                    shipping_county_tax_amount + shipping_state_tax_amount
                WHERE ord_id = _ord_id;

                WITH lines AS (
                    SELECT ol.ord_id,
                        SUM(ol.qty_available * ol.discount_amount) AS discount_amount,
                        SUM(ol.qty_available * ol.retail_amount) AS line_amount,
                        SUM(ol.qty_available * ol.local_tax_amount) AS line_local_tax_amount,
                        SUM(ol.qty_available * ol.county_tax_amount) AS line_county_tax_amount,
                        SUM(ol.qty_available * ol.state_tax_amount) AS line_state_tax_amount,
                        SUM(ol.qty_available * ol.tax_amount) AS line_tax_amount
                    FROM ord_line ol
                    WHERE ol.ord_id = _ord_id
                    GROUP BY ol.ord_id
                )
                UPDATE ord_header oh SET
                    line_amount = l.line_amount,
                    line_tax_amount = l.line_tax_amount,
                    line_local_tax_amount = l.line_local_tax_amount,
                    line_county_tax_amount = l.line_county_tax_amount,
                    line_state_tax_amount = l.line_state_tax_amount,
                    discount_amount = l.discount_amount,
                    order_amount = (
                        oh.shipping_amount +
                        oh.shipping_tax_amount +
                        l.line_amount +
                        l.line_tax_amount -
                        l.discount_amount
                    )
                FROM lines l
                WHERE oh.ord_id = l.ord_id;

                RETURN TRUE;
            END;
            $$ LANGUAGE plpgsql
        ");
    }

    public function down()
    {
        $this->execute("DROP FUNCTION IF EXISTS calculate_order(_ord_id integer)");
        $this->execute("DROP FUNCTION IF EXISTS lookup_order(_division text, _order_num text)");
        $this->execute("DROP FUNCTION IF EXISTS lock_order(_ord_id integer, _status_id integer, _reason text)");
        $this->execute("DROP FUNCTION IF EXISTS unlock_order(_ord_id integer, _status_id integer)");

        $this->execute("DROP TABLE IF EXISTS ord_lock CASCADE");
        $this->execute("DROP TABLE IF EXISTS ord_pay CASCADE");
        $this->execute("DROP TABLE IF EXISTS ord_line CASCADE");
        $this->execute("DROP TABLE IF EXISTS ord_ship CASCADE");
        $this->execute("DROP TABLE IF EXISTS ord_header CASCADE");

        $this->execute("DROP FUNCTION IF EXISTS calculate_ord_line_buckets()");
    }

}
