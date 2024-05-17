ALTER TABLE "SYSTEM"."CARTITEMS"
ADD "QUANTITY" NUMBER DEFAULT 1 NOT NULL;

ALTER TABLE "SYSTEM"."PRODUCTS"
ADD "USERID" NUMBER;

ALTER TABLE "SYSTEM"."PRODUCTS"
ADD CONSTRAINT "FK_PRODUCTS_USERS"
    FOREIGN KEY ("USERID")
    REFERENCES "SYSTEM"."USERS" ("USERID")
    ON DELETE SET NULL ENABLE;

ALTER TABLE ORDERS ADD (
    ZIPCODE       NUMBER,
    CITY          VARCHAR2(50),
    ADDRESS       VARCHAR2(150),
    ORDERDATE     DATE DEFAULT SYSDATE
);

ALTER TABLE "SYSTEM"."USERS"
ADD "FrequentBuyer" CHAR(1 BYTE) DEFAULT 'N';

ALTER TABLE "SYSTEM"."USERS"
ADD CONSTRAINT chk_frequentbuyer CHECK ("FrequentBuyer" IN ('Y', 'N'));

ALTER TABLE "SYSTEM"."PRODUCTS"
ADD "CREATION_DATE" DATE DEFAULT SYSDATE NOT NULL;

ALTER TABLE "SYSTEM"."ORDERS"
ADD "PAYED" CHAR(1 BYTE) DEFAULT 'N';

ALTER TABLE "SYSTEM"."ORDERS"
ADD "WARNING_OVERDUE" CHAR(1 BYTE) DEFAULT 'N';

ALTER TABLE "SYSTEM"."ORDERS"
ADD "DeliveryDate" DATE;

CREATE TABLE ORDERITEMS (
    ORDERITEMSID NUMBER GENERATED BY DEFAULT AS IDENTITY PRIMARY KEY,
    ORDERID      NUMBER NOT NULL
        CONSTRAINT ORDERITEMS_ORDERS_ORDERID_FK
            REFERENCES ORDERS (ORDERID)
            ON DELETE CASCADE,
    PRODUCTID    NUMBER NOT NULL
        CONSTRAINT ORDERITEMS_PRODUCTS_PRODUCTID_FK
            REFERENCES PRODUCTS (PRODUCTID)
            ON DELETE CASCADE,
    QUANTITY     NUMBER,
    PRICE        FLOAT
);

CREATE OR REPLACE NONEDITIONABLE TRIGGER "SYSTEM"."TRG_FREQUENT_BUYER"
FOR INSERT ON "SYSTEM"."ORDERS"
COMPOUND TRIGGER

    -- Define a type for storing user IDs.
    TYPE t_user_ids IS TABLE OF NUMBER INDEX BY BINARY_INTEGER;
    -- Declare a variable of the defined type.
    v_user_ids t_user_ids;

    -- Before any row is inserted in the "ORDERS" table, this block is executed.
    BEFORE STATEMENT IS
    BEGIN
        -- Clear the v_user_ids table to ensure it starts empty for each statement execution.
        v_user_ids.DELETE;
    END BEFORE STATEMENT;

    -- After each row is inserted in the "ORDERS" table, this block is executed.
    AFTER EACH ROW IS
    BEGIN
        -- Store the USERID of the newly inserted row in the v_user_ids table.
        v_user_ids(:NEW.USERID) := :NEW.USERID;
    END AFTER EACH ROW;

    -- After all rows have been inserted in the "ORDERS" table, this block is executed.
    AFTER STATEMENT IS
    BEGIN
        DECLARE
            -- Declare variables to hold the purchase count and user ID.
            v_purchase_count NUMBER;
            v_user_id NUMBER;
        BEGIN
            -- Initialize the loop with the first user ID stored in v_user_ids.
            v_user_id := v_user_ids.FIRST;
            WHILE v_user_id IS NOT NULL LOOP
                -- Count the number of orders for the current user ID.
                SELECT COUNT(*) INTO v_purchase_count FROM "SYSTEM"."ORDERS" WHERE USERID = v_user_ids(v_user_id);
                -- If the user has made 5 or more purchases, update their "FrequentBuyer" status.
                IF v_purchase_count >= 5 THEN
                    UPDATE "SYSTEM"."USERS" SET "FrequentBuyer" = 'Y' WHERE "USERID" = v_user_ids(v_user_id);
                END IF;
                -- Move to the next user ID in v_user_ids.
                v_user_id := v_user_ids.NEXT(v_user_id);
            END LOOP;
        EXCEPTION
            -- Handle any exceptions that occur within the AFTER STATEMENT block.
            WHEN OTHERS THEN
                NULL; -- Ignore exceptions to prevent the trigger from failing.
        END;
    END AFTER STATEMENT;

END TRG_FREQUENT_BUYER;

CREATE OR REPLACE NONEDITIONABLE TRIGGER "SYSTEM"."TRG_BALANCE_CHECK"
BEFORE UPDATE OF "BALANCE" ON "SYSTEM"."USERS"
FOR EACH ROW
BEGIN
    -- Check if the new balance is less than 0
    IF :NEW."BALANCE" < 0 THEN
        -- Set the balance to 0 if it is less than 0
        :NEW."BALANCE" := 0;
    END IF;
END TRG_BALANCE_CHECK;

CREATE TABLE SYSTEM.INVOICES (
    INVOICEID NUMBER GENERATED AS IDENTITY (START WITH 1 INCREMENT BY 1) 
        CONSTRAINT INVOICES_PK PRIMARY KEY,
    ORDERID NUMBER
        CONSTRAINT INVOICES_ORDERS_ORDERID_FK REFERENCES SYSTEM.ORDERS(ORDERID),
    BLOB_DATA BLOB
);

ALTER TABLE SYSTEM.USERS
ADD BALANCE NUMBER(10, 2) DEFAULT 0;

ALTER TABLE SYSTEM.USERS
ADD CARD_NUMBER NUMBER(10, 2) DEFAULT 0;

ALTER TABLE SYSTEM.USERS
ADD CVC NUMBER(10, 2) DEFAULT 0;

ALTER TABLE SYSTEM.USERS
ADD EXPIRY_DATE NUMBER(10, 2) DEFAULT 0;