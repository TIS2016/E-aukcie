import java.io.IOException;
import java.math.BigDecimal;
import java.util.ArrayList;
import java.util.List;

import com.fasterxml.jackson.core.JsonGenerationException;
import com.fasterxml.jackson.databind.JsonMappingException;
import com.fasterxml.jackson.databind.ObjectMapper;
import com.fasterxml.jackson.databind.exc.UnrecognizedPropertyException;

public class Jackson2Example {
	
	Object x;

    public Jackson2Example(String action, String source) {

        this.run(action, source);
    }

    private void run(String action, String jsonInString) {
        ObjectMapper mapper = new ObjectMapper();

        try {
 
            if (jsonInString==null){
                return;
            }
            
            String prettyStaff1;
            switch (action){
                case "addCriterionItemToCriterion":
                    x = mapper.readValue(jsonInString, Order.class);
                    break;
                case "setAuction":
                    x = mapper.readValue(jsonInString, AuctionData.class);                
                    break;
                case "setCriterionsForUser":
                	try{
                		 x = mapper.readValue(jsonInString, Auction.class);
                	}catch(Exception e){
                		try{
                			x = mapper.readValue(jsonInString, Item.class);              		
                		}catch(Exception es){
                			
                		}
                	}
                   
                    break;
                case "setCriterionForAuctionRound":
                	x = mapper.readValue(jsonInString, Round.class);
                    break;
                case "prolongAuctionRound":
                	x = jsonInString;
                    break;                    
                case "setAuctionRound":
                    x = mapper.readValue(jsonInString, AuctionData.class);
                    break;        
                case "addUserToAuction":
                    x = mapper.readValue(jsonInString,User.class);
                    break;                    
                case "setUserInAuction":
                    x = mapper.readValue(jsonInString,User.class);
                    break;                    
                case "removeCriterionItemFromCriterion":

                	x = jsonInString;
                    break;
                	
                default:
                	break;
            }





        } catch (JsonGenerationException e) {
            e.printStackTrace();
        } catch (JsonMappingException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
    
    public Object getValue(){
    	return x;
    }
    
   
    
 

}