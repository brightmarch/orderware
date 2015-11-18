<?php

use Phinx\Migration\AbstractMigration;

class CreateLedgerTables extends AbstractMigration
{

    public function up()
    {
        $this->execute("
            CREATE TABLE ledger_code (
                ledger_code text NOT NULL,
                description text NOT NULL,
                invert integer NOT NULL DEFAULT 1,
                settles boolean NOT NULL DEFAULT true,
                CONSTRAINT ledger_code_pkey PRIMARY KEY (ledger_code)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("
            INSERT INTO ledger_code VALUES
                ('LA', 'Line Amount', 1, true),
                ('LTA', 'Line Tax Amount', 1, true),
                ('LDA', 'Line Discount Amount', -1, true),

                ('LCA', 'Line Canceled Amount', -1, false),
                ('LCTA', 'Line Canceled Tax Amount', -1, false),
                ('LCDA', 'Line Canceled Discount Amount', 1, false),

                ('LRA', 'Line Returned Amount', -1, true),
                ('LRTA', 'Line Returned Tax Amount', -1, true),
                ('LRDA', 'Line Returned Discount Amount', 1, true),

                ('OSA', 'Order Shipping Amount', 1, true),
                ('OSTA', 'Order Shipping Tax Amount', 1, true)
        ");

        $this->execute("
            CREATE TABLE ledger (
                ledger_id serial NOT NULL,
                created_at timestamp without time zone NOT NULL DEFAULT LOCALTIMESTAMP(0),
                updated_at timestamp without time zone NOT NULL DEFAULT LOCALTIMESTAMP(0),
                created_by text NOT NULL,
                updated_by text NOT NULL,
                division text NOT NULL REFERENCES division (division) ON DELETE CASCADE,
                ord_id integer NOT NULL REFERENCES ord_header (ord_id) ON DELETE CASCADE,
                ord_line_id integer REFERENCES ord_line (ord_line_id) ON DELETE CASCADE,
                status_id integer NOT NULL REFERENCES status (status_id),
                ledger_code text NOT NULL REFERENCES ledger_code (ledger_code),
                invoiced_at timestamp without time zone,
                settled_at timestamp without time zone,
                amount integer NOT NULL DEFAULT 0,
                CONSTRAINT ledger_pkey PRIMARY KEY (ledger_id)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("CREATE INDEX ledger_division_idx ON ledger (division)");
        $this->execute("CREATE INDEX ledger_ord_id_idx ON ledger (ord_id)");
        $this->execute("CREATE INDEX ledger_ord_line_id_idx ON ledger (ord_line_id) WHERE ord_line_id IS NOT NULL");
        $this->execute("CREATE INDEX ledger_status_id_idx ON ledger (status_id)");
        $this->execute("CREATE INDEX ledger_ledger_code_idx ON ledger (ledger_code)");
        $this->execute("CREATE INDEX ledger_invoiced_at_idx ON ledger (invoiced_at)");
        $this->execute("CREATE INDEX ledger_settled_at_idx ON ledger (settled_at)");
        $this->execute("CREATE INDEX ledger_settle_date_idx ON ledger (DATE(settled_at))");

        $this->execute("
            CREATE OR REPLACE FUNCTION calculate_ledger_values() RETURNS TRIGGER AS $$
            DECLARE
                _invert integer;
                _settles boolean;
            BEGIN
                SELECT INTO _invert, _settles
                    lc.invert, lc.settles
                FROM ledger_code lc
                WHERE lc.ledger_code = NEW.ledger_code;

                NEW.amount = NEW.amount * _invert;

                IF NOT _settles THEN
                    NEW.status_id = 320;
                    NEW.invoiced_at = LOCALTIMESTAMP(0);
                    NEW.settled_at = LOCALTIMESTAMP(0);
                END IF;

                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql
        ");

        $this->execute("
            CREATE TRIGGER calculate_ledger_values_on_insert_on_update
            BEFORE INSERT OR UPDATE ON ledger
            FOR EACH ROW EXECUTE PROCEDURE calculate_ledger_values()
        ");

        $this->execute("
            CREATE OR REPLACE FUNCTION get_ledger_amount(_ord_id integer, _ord_line_id integer, _ledger_code text) RETURNS integer AS $$
            DECLARE
                _amount integer;
            BEGIN

                SELECT INTO _amount COALESCE(SUM(l.amount), 0)
                FROM ledger l
                WHERE l.ord_id = _ord_id
                    AND (
                        CASE WHEN _ord_line_id IS NULL
                        THEN l.ord_line_id IS NULL
                        ELSE l.ord_line_id = _ord_line_id END
                    )
                    AND l.ledger_code = _ledger_code;

                RETURN _amount;
            END;
            $$ LANGUAGE plpgsql
        ");
    }

    public function down()
    {
        $this->execute("DROP TABLE IF EXISTS ledger_code CASCADE");
        $this->execute("DROP TABLE IF EXISTS ledger CASCADE");

        $this->execute("DROP FUNCTION IF EXISTS calculate_ledger_amount()");
        $this->execute("DROP FUNCTION IF EXISTS get_ledger_amount(_ord_id integer, _ord_line_id integer, _ledger_code text)");
    }

}
