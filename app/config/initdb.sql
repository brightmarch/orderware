BEGIN;

INSERT INTO account (
    account, created_at, updated_at, created_by, updated_by, status_id,
    display_name, currency, time_zone, primary_email,
    notification_email, merch_description
) SELECT 'GROWERS', LOCALTIMESTAMP(0), LOCALTIMESTAMP(0), 'initdb', 'initdb', 1,
    'Growers Coffee', 'USD', 'America/Chicago', 'orders@growerscoffee.com',
    'orders@growerscoffee.com', 'organic coffee'
FROM account HAVING COUNT(account) = 0;

COMMIT;
