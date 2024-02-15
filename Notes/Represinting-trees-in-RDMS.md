## Detect and prevent cycles

### Detect and prevent cycles when updating records
#### Code
    CREATE TRIGGER trg_prevent_cycles  
        BEFORE UPDATE ON product_categories  
        FOR EACH ROW  
    BEGIN  
        DECLARE temp_parent INT;  
        DECLARE temp_category_id INT;  
      
     SET temp_parent = NEW.parent_id; SET temp_category_id = NEW.id;  
     WHILE temp_parent IS NOT NULL DO IF temp_parent = temp_category_id THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot create cycle in Category hierarchy'; END IF;  
     SELECT parent_id INTO temp_parent FROM product_categories WHERE id = temp_parent; END WHILE;END;  


-- -----------------------------------------------------------------------  
#### Approximate time
If
* n is the number of affected records
* k is the number of nodes till the root node or till we reach the starting node again (detect a cycle)
* r  is the number of rows in the table
Then it should take O(n * k * log ( r ) ) operation
**Note that this is my estmation and may be wrong and also it depends on how the query optizer decide to execute the query**





### Detect and prevent cycles when updating records (Another Approach)
    -- detect and prevent cycles  
    CREATE TRIGGER trg_prevent_cycles_when_creating  
        BEFORE UPDATE ON product_categories  
        FOR EACH ROW  
    BEGIN  
        DECLARE is_cycle INT DEFAULT 0;  
      
     -- Using a recursive CTE to get the entire path 
     WITH RECURSIVE CategoryPath AS ( 
     SELECT id, parent_id
    	 FROM product_categories WHERE id = NEW.parent_id 
    	 UNION ALL 
    		 SELECT c.id, c.parent_id 
    			 FROM product_categories c 
    			 JOIN CategoryPath cp ON c.id = cp.parent_id
       ) 
    	 SELECT COUNT(*) INTO is_cycle 
    	 FROM CategoryPath WHERE id = NEW.id;  
    	 IF is_cycle > 0 
    	 THEN
    	 SIGNAL SQLSTATE '45000' 
    	 SET MESSAGE_TEXT = 'Cannot create cycle in category hierarchy';  
     END IF;  
    END;  





### Detect and prevent cycles when inseting new records

    -- detect and prevent cycles  
    CREATE TRIGGER IF NOT EXISTS trg_prevent_cycles_when_inserting  
        BEFORE INSERT ON product_categories  
        FOR EACH ROW  
    BEGIN  
      
     IF NEW.id = NEW.parent_id 
     THEN 
	     SIGNAL SQLSTATE '45000' 
	     SET MESSAGE_TEXT = 'Cannot create cycle in category hierarchy';  
     END IF;  
    END;  






