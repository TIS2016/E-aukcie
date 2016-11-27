package screenshot;

import java.io.File;

import org.apache.commons.io.FileUtils;
import org.openqa.selenium.OutputType;
import org.openqa.selenium.TakesScreenshot;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.firefox.FirefoxDriver;

public class Screenshot {

  private final WebDriver driver = new FirefoxDriver();
  private String website;

  public Screenshot(String website) {
    this.website = website;
  }

  public void open() throws Exception {
    try {
      driver.get(website);
    }
    finally { }
  }

  public void take() throws Exception {
    int i = 0;
    File f = new File("../screenshots/" + i + ".png");

    while (f.exists()) {
      f = new File("../screenshots/" + ++i + ".png");
    }

    final File screenShot = f.getAbsoluteFile();

    try {
      final File outputFile = ((TakesScreenshot) driver).getScreenshotAs(OutputType.FILE);
      FileUtils.copyFile(outputFile, screenShot);
    }
    finally { }
  }

  public void close() {
    driver.quit();
  }

}

