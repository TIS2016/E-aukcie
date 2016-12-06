package screenshot;

import java.awt.BorderLayout;
import javax.swing.*;

public class ScreenshotGUI {

  private static JLabel     lblSite = new JLabel("Website:");
  private static JTextField txtSite = new JTextField("", 50);

  private static void createAndShowGUI() {
    JPanel pnlSite = new JPanel();
    JPanel pnlOp   = new PanelOp();

    pnlSite.add(lblSite);
    pnlSite.add(txtSite);

    JFrame frame = new JFrame("Screenshot taker");

    frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
    frame.getContentPane().add(pnlSite, BorderLayout.PAGE_START);
    frame.getContentPane().add(pnlOp);

    frame.pack();
    frame.setVisible(true);
  }

  public static String getWebsite() {
    return txtSite.getText();
  }

  public static void main(String[] args) {
    javax.swing.SwingUtilities.invokeLater(new Runnable() {
      public void run() {
        createAndShowGUI();
      }
    });
  }

}

