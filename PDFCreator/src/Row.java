import java.util.ArrayList;

public class Row implements Comparable<Row>{

    String poradie;
    String alias;
    String firma;
    Double cena;
    String zaruka;
    Auction auction;


    public Row(String alias, String cena, String zaruka) {
        this.alias = alias;
        this.cena = Double.valueOf(cena);
        this.zaruka = zaruka;
    }

    public Row(String alias, String zaruka, Auction auction, String firma, boolean isFinal) {
        this.alias = alias;
        this.auction = auction;
        this.zaruka = zaruka;
        this.firma = firma;
        countCena(isFinal);
    }

    private void countCena(boolean isFinal){
        if (isFinal){
            cena = (double) Math.round(auction.numericValue*100)/100;
        }else{
            cena = (double) Math.round((auction.numericValue-((double)(auction.items.get(0).difference)))*100)/100;
        }

    }


    @Override
    public int compareTo(Row o) {
        return cena.compareTo(o.cena);
    }


    public ArrayList<String> toArray(){
        ArrayList<String> arrayList = new ArrayList<>();
        arrayList.add(poradie);
        arrayList.add(alias);
        arrayList.add(firma);
        arrayList.add(cena.toString());
        arrayList.add(zaruka);

        return arrayList;
    }

    @Override
    public String toString() {
        return "Row{" +
                "poradie='" + poradie + '\'' +
                ", alias='" + alias + '\'' +
                ", firma='" + firma + '\'' +
                ", cena=" + cena +
                ", zaruka='" + zaruka + '\'' +
                '}';
    }
}
