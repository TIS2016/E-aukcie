
import java.util.List;

public class Auction {

    public int idInAuction;
    public String criterionType;
    public boolean listType;
    public String nameInAuction;
    public List<Item> items;
    public double numericValue;
    
    @Override
    public String toString() {
        return  "idInAuction: " + idInAuction + "," + " criterionType: " + criterionType + "," + " listType: " + listType + "," + " nameInAuction: " + nameInAuction + "," + " numericValue: " + numericValue  ;
    }
    

}

class LastModified
{
    public int date;
    public int day;
    public int hours;
    public int minutes;
    public int month;
    public int seconds;
    public long time;
    public int timezoneOffset;
    public int year;
}

class Item
{
    public int amount;
    public int bestLongValue;
    public int bestValue;
    public List<Object> children;
    public String code;
    public int criterionId;
    public String description;
    public double difference;
    public int itemId;
    public boolean lastModification;
    public LastModified lastModified;
    public boolean leaf;
    public int level;
    public int longAmount;
    public int longDifference;
    public int longPricePerUnit;
    public int longValue;
    public String name;
    public boolean nullValue;
    public int oldLongPricePerUnit;
    public int oldLongValue;
    public double oldPricePerUnit;
    public double oldValue;
    public int order;
    public int parentItemId;
    public double pricePerUnit;
    public boolean reindexed;
    public String unitType;
    public double value;
    public boolean auctionable;
 
    public int defaultAmount;
    public int defaultLongAmount;
    public int defaultLongUnitPrice;
    public int defaultUnitPrice;
   
    public int id;
    public String itemType;
    public Object parent;
    public String settings;
  
}

/**************************************/

class Order
{
    public int order;
    public String name;
    public int amount;
    public String code;
    public int criterionId;
    public String unitType;
    public int itemId;
    public int parentItemId;
    
    
    @Override
    public String toString() {
        return  "order: " + order + "," + " name: " + name + "," + " amount: " + amount + "," + " code: " + code + "," + " criterionId: " + 
    criterionId + "," + " unitType: " + unitType + "," + " itemId: " + itemId + "," + " parentItemId: " + parentItemId  ;
    }
    
}

/**************************************/

class BeginingTime
{
    public int date;
    public int day;
    public int hours;
    public int minutes;
    public int month;
    public int seconds;
    public long time;
    public int timezoneOffset;
    public int year;
}

class EndTime
{
    public int date;
    public int day;
    public int hours;
    public int minutes;
    public int month;
    public int seconds;
    public long time;
    public int timezoneOffset;
    public int year;
}

class AuctionData
{
    public BeginingTime beginingTime;
    public boolean bestCriterionsVisible;
    public boolean bestOfferVisible;
    public String compareAlgorithm;
    public boolean criterionOrdersVisible;
    public EndTime endTime;
    public boolean orderVisible;
    public int prolongTime;
    public int round;
    public boolean roundActive;
    public String roundDescription;
    public String roundType;
    public Object serverTime;
    public boolean visibleToParticipants;
    public boolean activeRound;
    public String auctionStatus;
    public String auctionType;
    public String currency;
    public String description;
    public boolean descriptionNonEmpty;
    public int id;
    public Item item;
    public int itemCount;
    public String name;
    public int pricePerUnit;
    public Project project;
    public Owner owner;
    public String bestCriterionsVisibleB;
    public String bestOfferVisibleB;
    public String criterionOrdersVisibleB;
    public String modifiable;
    public String orderVisibleB;
    public String prolongTimeString;
    public String roundActiveTranslation;
    public String roundTypeDescription;
    public String visibleToParticipantsInt;
    
    @Override
    public String toString() {
        return  "beginingTime: " + beginingTime + "," + " compareAlgorithm: " + compareAlgorithm + "," + " endTime: " + endTime + "," + " roundType: " + roundType + "," + " bestOfferVisibleB: " + 
    bestOfferVisibleB + "," + " bestCriterionsVisibleB: " + bestCriterionsVisibleB + "," + " orderVisible: " + orderVisible + "," + " roundDescription: " + roundDescription +"," + " prolongTimeString: " + prolongTimeString + ","
    + " bestCriterionsVisible: " + bestCriterionsVisible + "," + "visibleToParicipantsInt: " + visibleToParticipantsInt;
    }
    
}


class Owner
{
    public String accessKey;
    public boolean active;
    public String alias;
    public List<Object> auctionInfos;
    public int auctionOrder;
    public String auctionRole;
    public Object auctionRoundInfo;
    public int auctionScore;
    public Object client;
    public List<Object> criterions;
    public boolean disabled;
    public String email;
    public List<Object> itemRoots;
    public Object lastLogIn;
    public String login;
    public boolean moderator;
    public String name;
    public String password;
    public String phone;
    public String role;
    public boolean safePassword;
    public String skin;
    public String surname;
    public int userCoeficient;
    public Object validFrom;
    public Object validUntil;
}

class ValidFrom
{
    public int date;
    public int day;
    public int hours;
    public int minutes;
    public int month;
    public int seconds;
    public long time;
    public int timezoneOffset;
    public int year;
}

class ValidUntil
{
    public int date;
    public int day;
    public int hours;
    public int minutes;
    public int month;
    public int seconds;
    public long time;
    public int timezoneOffset;
    public int year;
}

class Project
{
    public boolean active;
    public Object client;
    public String description;
    public boolean descriptionNonEmpty;
    public List<Object> files;
    public int id;
    public List<Object> itemRoots;
    public String name;
    public Owner owner;
    public Object timeCreated;
    public ValidFrom validFrom;
    public ValidUntil validUntil;
}

class Round
{
    public int round;
    public String criterionType;
    public String listType;
    public String priceType;
    public int comparisonValue;
    public String description;
    public String nameInAuction;
    public int direction;
    public int idInAuction;
    public int minimalStep;
    public int priority;
    public String bestInputValue;
    public String orderVisible;
    public String criterionItemUnification;
    public int minAllowedValue;
    public int maxAllowedValue;
    
    @Override
    public String toString() {
        return  "round: " + round + "," + " criterionType: " + criterionType + "," + " comparisonValue: " + comparisonValue + "," + " description: " + description + "," + " idInAuction: " + 
    idInAuction + "," + " bestInputValue: " + bestInputValue + "," + " minAllowedValue: " + minAllowedValue + "," + " maxAllowedValue: " + maxAllowedValue  ;
    }
}

class User
{
    public boolean active;
    public String alias;
    public String auctionRole;
    public int userCoeficient;
    
    @Override
    public String toString() {
        return  "active: " + active + "," + " alias: " + alias + "," + " auctionRole: " + auctionRole + "," + " userCoeficient: " + userCoeficient;
    }
}


class setAuction
{
    public int activeRound;
    public String auctionStatus;
    public String auctionType;
    public String currency;
    public String description;
    public boolean descriptionNonEmpty;
    public int id;
    public Item item;
    public int itemCount;
    public String name;
    public int pricePerUnit;
    public Project project;
}


class AuctionLine{
	String time;
	String action;
	String user;
	Object value;
	
	AuctionLine(String t, String action, String user, Object v){
		time = t;
		this.action = action;
		this.user = user;
		value = v;
	}
	
}



