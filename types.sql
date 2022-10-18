--
-- File generated with SQLiteStudio v3.2.1 on Thu Sep 29 11:45:15 2022
--
-- Text encoding used: System
--

-- Table: types
DROP TABLE IF EXISTS types;

CREATE TABLE types (
    type_id   INTEGER PRIMARY KEY,
    type_name TEXT
);

INSERT INTO types (
                      type_id,
                      type_name
                  )
                  VALUES (
                      1,
                      'Band/Group'
                  );

INSERT INTO types (
                      type_id,
                      type_name
                  )
                  VALUES (
                      2,
                      'Duo'
                  );

INSERT INTO types (
                      type_id,
                      type_name
                  )
                  VALUES (
                      3,
                      'Solo'
                  );

INSERT INTO types (
                      type_id,
                      type_name
                  )
                  VALUES (
                      4,
                      'Trio'
                  );


