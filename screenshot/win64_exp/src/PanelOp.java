package screenshot;

import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import javax.swing.*;

import screenshot.Screenshot;

public class PanelOp extends JPanel implements ActionListener {

  private JButton btnOpen  = new JButton("Open");
  private JButton btnTake  = new JButton("Take screenshot");
  private JButton btnClose = new JButton("Close");

  private Screenshot screenshot;

  public PanelOp() {
    add(btnOpen);
    add(btnTake);
    add(btnClose);

    btnOpen.setActionCommand("open");
    btnTake.setActionCommand("take");
    btnClose.setActionCommand("close");

    btnOpen.addActionListener(this);
    btnTake.addActionListener(this);
    btnClose.addActionListener(this);

    btnTake.setEnabled(false);
    btnClose.setEnabled(false);
  }

  public void actionPerformed(ActionEvent e) {
    if (e.getActionCommand().equals("open")) {
      btnOpen.setEnabled(false);
      btnTake.setEnabled(true);
      btnClose.setEnabled(true);

      screenshot = new Screenshot(ScreenshotGUI.getWebsite());

      try {
        screenshot.open();
      }
      catch (Exception ex) {
        btnOpen.setEnabled(true);
        btnTake.setEnabled(false);
        btnClose.setEnabled(false);
      }
    }
    else if (e.getActionCommand().equals("take")) {
      try {
        screenshot.take();
      }
      catch (Exception ex) { }
    }
    else if (e.getActionCommand().equals("close")) {
      screenshot.close();
      screenshot = null;

      btnOpen.setEnabled(true);
      btnTake.setEnabled(false);
      btnClose.setEnabled(false);
    }
  }

}

