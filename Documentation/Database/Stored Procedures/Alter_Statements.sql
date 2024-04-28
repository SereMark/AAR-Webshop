ALTER TABLE "SYSTEM"."CARTITEMS"
ADD "QUANTITY" NUMBER DEFAULT 1 NOT NULL;

ALTER TABLE "SYSTEM"."PRODUCTS"
ADD "USERID" NUMBER;

ALTER TABLE "SYSTEM"."PRODUCTS"
ADD CONSTRAINT "FK_PRODUCTS_USERS" FOREIGN KEY ("USERID")
    REFERENCES "SYSTEM"."USERS" ("USERID") ON DELETE SET NULL ENABLE;

CREATE TABLE ORDERITEMS (
                            ORDERITEMSID NUMBER GENERATED BY DEFAULT AS IDENTITY PRIMARY KEY,
                            ORDERID      NUMBER NOT NULL
                                CONSTRAINT ORDERITEMS_ORDERS_ORDERID_FK
                                    REFERENCES ORDERS,
                            PRODUCTID    NUMBER NOT NULL
                                CONSTRAINT ORDERITEMS_PRODUCTS_PRODUCTID_FK
                                    REFERENCES PRODUCTS,
                            QUANTITY     NUMBER,
                            PRICE        FLOAT
);