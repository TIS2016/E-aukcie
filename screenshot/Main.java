/*
 * #%L
 * Take a Screenshot of Webpage
 * %%
 * Copyright (C) 2012 - 2015 Java Creed
 * %%
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *      http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * #L%
 */


import java.io.File;
import java.util.concurrent.TimeUnit;

import org.apache.commons.io.FileUtils;
import org.openqa.selenium.OutputType;
import org.openqa.selenium.TakesScreenshot;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

public class Main {

  public static final Logger LOGGER = LoggerFactory.getLogger(Main.class);

  public static void main(final String[] args) throws Exception {
    final String link = args[0];
    final File screenShot = new File("screenshot.png").getAbsoluteFile();

    Main.LOGGER.debug("Creating Firefox Driver");
    final WebDriver driver = new FirefoxDriver();
    try {
      Main.LOGGER.debug("Opening page: {}", link);
      driver.get(link);

      Main.LOGGER.debug("Wait a bit for the page to render");
      TimeUnit.SECONDS.sleep(5);

      Main.LOGGER.debug("Taking Screenshot");
      final File outputFile = ((TakesScreenshot) driver).getScreenshotAs(OutputType.FILE);
      FileUtils.copyFile(outputFile, screenShot);
      Main.LOGGER.debug("Screenshot saved: {}", screenShot);
    } finally {
      driver.close();
    }

    Main.LOGGER.debug("done");
  }
}
