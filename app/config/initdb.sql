BEGIN;

-- Clear Data
DELETE FROM account WHERE account = 'GROWERS';
DELETE FROM feed_connection WHERE type = 'local';

-- Account
INSERT INTO account (account, created_at, updated_at, created_by, updated_by, status_id, display_name, currency, time_zone, primary_email, notification_email, merch_description) VALUES ('GROWERS', LOCALTIMESTAMP(0), LOCALTIMESTAMP(0), 'initdb', 'initdb', 1, 'Growers Coffee', 'USD', 'America/Chicago', 'orders@growerscoffee.com', 'orders@growerscoffee.com', 'organic coffee');

-- Feeds
INSERT INTO feed_connection (connection_id, created_at, updated_at, created_by, updated_by, type, name, host, username, password, port, private_key, timeout) VALUES (default, LOCALTIMESTAMP(0), LOCALTIMESTAMP(0), 'initdb', 'initdb', 'local', 'Local Filesystem', null, null, null, 0, null, 0);

INSERT INTO feed (feed_id, created_at, updated_at, created_by, updated_by, account, status_id, connection_id, direction, name, service, remote_root_dir, local_root_dir, filename) VALUES (default, LOCALTIMESTAMP(0), LOCALTIMESTAMP(0), 'initdb', 'initdb', 'GROWERS', 1, (SELECT connection_id FROM feed_connection WHERE type = 'local'), 'inbound', 'catalog', 'orderware.feeds.catalog_feed_processor', '/var/apps/data/remote/catalog', '/var/apps/data/local/catalog', '/growers_catalog_(.*).xml/');

COMMIT;
