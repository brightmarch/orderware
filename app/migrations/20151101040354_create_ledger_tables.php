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
                CONSTRAINT ledger_code_pkey PRIMARY KEY (ledger_code)
            ) WITH (OIDS=FALSE)
        ");

        $this->execute("
            INSERT INTO ledger_code VALUES
                ('LA', 'Line Amount'),
                ('LTA', 'Line Tax Amount'),
                ('LDA', 'Line Discount Amount'),

                ('OSA', 'Order Shipping Amount'),
                ('OSTA', 'Order Shipping Tax Amount')
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
                canceled_at timestamp without time zone,
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
        $this->execute("CREATE INDEX ledger_canceled_at_idx ON ledger (canceled_at)");
    }

    public function down()
    {
        $this->execute("DROP TABLE IF EXISTS ledger_code CASCADE");
        $this->execute("DROP TABLE IF EXISTS ledger CASCADE");
    }

}
