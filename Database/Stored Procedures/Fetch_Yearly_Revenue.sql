-- Creating or replacing an existing procedure named Fetch_Yearly_Revenue
CREATE OR REPLACE PROCEDURE Fetch_Yearly_Revenue(p_cursor OUT SYS_REFCURSOR) IS
BEGIN
  -- Opening a cursor to hold and return the result set
  OPEN p_cursor FOR
    -- Selecting the formatted order date as Month and the sum of total amount as Revenue
    SELECT TO_CHAR(ORDERDATE, 'YYYY-MM') AS Month, SUM(TOTALAMOUNT) AS Revenue
    FROM SYSTEM.ORDERS
    -- Filtering records for the current year
    WHERE EXTRACT(YEAR FROM ORDERDATE) = EXTRACT(YEAR FROM SYSDATE)
    -- Grouping the results by month
    GROUP BY TO_CHAR(ORDERDATE, 'YYYY-MM')
    -- Ordering the results by month
    ORDER BY Month;
END Fetch_Yearly_Revenue;