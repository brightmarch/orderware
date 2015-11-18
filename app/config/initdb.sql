BEGIN;

INSERT INTO division (
    division, created_at, updated_at, created_by, updated_by, status_id,
    display_name, currency, time_zone, primary_email,
    notification_email, merch_description
) SELECT 'GROWERS', LOCALTIMESTAMP(0), LOCALTIMESTAMP(0), 'orderware', 'orderware', 1,
    'Growers Coffee', 'USD', 'America/Chicago', 'orders@growerscoffee.com',
    'orders@growerscoffee.com', 'organic coffee'
FROM division HAVING COUNT(division) = 0;

INSERT INTO login (
    created_at, updated_at, created_by, updated_by, division, status_id,
    full_name, username, password_hash, time_zone, role
) SELECT LOCALTIMESTAMP(0), LOCALTIMESTAMP(0), 'orderware', 'orderware', 'GROWERS', 1,
    'api_growers', 'api_growers', 'password', 'America/Chicago', 'ROLE_STATELESS'
WHERE NOT EXISTS (
    SELECT username FROM login WHERE username = 'api_growers'
);

COMMIT;
