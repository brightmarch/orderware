BEGIN;

-- Account
INSERT INTO account (account, created_at, updated_at, created_by, updated_by, status_id, display_name, currency, time_zone, primary_email, notification_email, merch_description) VALUES ('GROWERS', LOCALTIMESTAMP(0), LOCALTIMESTAMP(0), 'initdb', 'initdb', 1, 'Growers Coffee', 'USD', 'America/Chicago', 'orders@growerscoffee.com', 'orders@growerscoffee.com', 'organic coffee');

-- Feeds
INSERT INTO feed (feed_id, created_at, updated_at, created_by, updated_by, status_id, direction, name, service, remote_root_dir, local_root_dir, filename) VALUES (default, LOCALTIMESAMP(0), LOCALTIMESTAMP(0), 'initdb', 'initdb', 1, 'inbound', 'item', 'orderware.feeds.item_feed_processor', '/var/apps/data/remote/catalog', '/var/apps/data/local/catalog', '/growers_item_(.*).xml/');

COMMIT;
