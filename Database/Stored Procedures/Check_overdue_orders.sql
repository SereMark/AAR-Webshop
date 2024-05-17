CREATE OR REPLACE PROCEDURE Update_Overdue_Warning AS
BEGIN
    -- Update the "orders" table to set the "Warning_Overdue" flag to 'Y' 
    -- for orders that are unpaid, made with 'Pay on delivery' payment method, 
    -- and are overdue by more than 5 days.
    UPDATE orders
    SET Warning_Overdue = 'Y'
    WHERE PaymentMethod = 'Pay on delivery'
      AND Payed = 'N'
      AND OrderDate < SYSDATE - 5;

    -- Commit the transaction to make the changes permanent.
    COMMIT;

EXCEPTION
    -- Exception handling block to catch any errors that occur during the update.
    WHEN OTHERS THEN
        -- Output the error message to the console for debugging purposes.
        dbms_output.put_line('Error occurred: ' || SQLERRM);
        -- Rollback the transaction to undo any changes made before the error occurred.
        ROLLBACK;
END Update_Overdue_Warning;