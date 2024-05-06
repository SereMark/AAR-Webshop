CREATE OR REPLACE PROCEDURE Update_Overdue_Warning AS
BEGIN
    UPDATE orders
    SET Warning_Overdue = 'Y'
    WHERE PaymentMethod = 'Pay on delivery'
      AND Payed = 'N'
      AND OrderDate < SYSDATE - 5;

    COMMIT;

EXCEPTION
    WHEN OTHERS THEN
        dbms_output.put_line('Error occurred: ' || SQLERRM);
        ROLLBACK;
END Update_Overdue_Warning;