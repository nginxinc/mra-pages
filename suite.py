# -*- coding: utf-8 -*-
from selenium.webdriver.chrome.webdriver import WebDriver
from selenium.webdriver.common.action_chains import ActionChains
import time, unittest

def is_alert_present(wd):
    try:
        wd.switch_to_alert().text
        return True
    except:
        return False

class integration(unittest.TestCase):
    wd = WebDriver()
    wd.implicitly_wait(60)

    def test_1about(self):
        success = True
        wd = self.wd
        wd.get("https://mra.nginxps.com/")
        wd.find_element_by_xpath("//header[@class='fixed-top-header']/div[1]/a/img").click()
        if not (len(wd.find_elements_by_link_text("LOG IN")) != 0):
            success = False
            print("verifyElementPresent failed")
        wd.find_element_by_link_text("About").click()
        if not ("About Microservices" in wd.find_element_by_tag_name("html").text):
            success = False
            print("verifyTextPresent failed")
        self.assertTrue(success)
    
    def test_2logInFacebook(self):
        success = True
        wd = self.wd
        wd.get("https://mra.nginxps.com/myphotos")
        wd.find_element_by_id("ing_fb_login").click()
        time.sleep(float(45000) / 1000)
        wd.refresh()
        wd.find_element_by_xpath("//header[@class='fixed-top-header']/div[1]/a/img").click()
        wd.find_element_by_link_text("LOG OUT").click()
        self.assertTrue(success)

    def test_3logInGoogle(self):
        success = True
        wd = self.wd
        wd.get("https://mra.nginxps.com/myphotos")
        wd.find_element_by_id("ing_gp_login").click()
        time.sleep(float(45000) / 1000)
        wd.refresh()
        wd.find_element_by_xpath("//header[@class='fixed-top-header']/div[1]/a/img").click()
        if not (len(wd.find_elements_by_link_text("LOG OUT")) != 0):
            success = False
            print("verifyElementPresent failed")
        self.assertTrue(success)
    
    def test_4updateEmail(self):
        success = True
        wd = self.wd
        wd.get("https://mra.nginxps.com/account")
        wd.find_element_by_id("email").click()
        wd.find_element_by_id("email").clear()
        wd.find_element_by_id("email").send_keys("old.email@nginx.com")
        wd.find_element_by_id("update-account-button").click()
        time.sleep(float(500) / 1000)
        wd.refresh()
        if wd.find_element_by_id("email").get_attribute("value") != "old.email@nginx.com":
            success = False
            print("verifyElementValue failed")
        wd.find_element_by_id("email").click()
        wd.find_element_by_id("email").clear()
        wd.find_element_by_id("email").send_keys("new.email@nginx.com")
        wd.find_element_by_id("update-account-button").click()
        time.sleep(float(500) / 1000)
        wd.refresh()
        if wd.find_element_by_id("email").get_attribute("value") != "new.email@nginx.com":
            success = False
            print("verifyElementValue failed")
        self.assertTrue(success)

    def test_5updateName(self):
        success = True
        wd = self.wd
        wd.get("https://mra.nginxps.com/account")
        wd.find_element_by_id("name").click()
        wd.find_element_by_id("name").clear()
        wd.find_element_by_id("name").send_keys("Old Name")
        wd.find_element_by_id("update-account-button").click()
        if wd.find_element_by_id("name-user").text != "Old Name":
            success = False
            print("verifyText failed")
        time.sleep(float(500) / 1000)
        wd.refresh()
        if wd.find_element_by_id("name-user").text != "Old Name":
            success = False
            print("verifyText failed")
        if wd.find_element_by_id("name").get_attribute("value") != "Old Name":
            success = False
            print("verifyElementValue failed")
        wd.find_element_by_id("name").click()
        wd.find_element_by_id("name").clear()
        wd.find_element_by_id("name").send_keys("New Name")
        wd.find_element_by_id("update-account-button").click()
        if not ("New Name" in wd.find_element_by_tag_name("html").text):
            success = False
            print("verifyTextPresent failed")
        time.sleep(float(500) / 1000)
        wd.refresh()
        if wd.find_element_by_id("name-user").text != "New Name":
            success = False
            print("verifyText failed")
        if wd.find_element_by_id("name").get_attribute("value") != "New Name":
            success = False
            print("verifyElementValue failed")
        self.assertTrue(success)

    def test_6createAlbum(self):
        success = True
        wd = self.wd
        wd.get("https://mra.nginxps.com/myphotos")
        wd.find_element_by_xpath("//div[@class='right-nav-btn']/a/img").click()
        wd.find_element_by_link_text("New Album").click()
        wd.find_element_by_id("album-name").click()
        wd.find_element_by_id("album-name").clear()
        wd.find_element_by_id("album-name").send_keys("TestSelenium")
        wd.find_element_by_id("album-photo-input").click()
        time.sleep(float(10000) / 1000)
        wd.find_element_by_css_selector("button.btn").click()
        time.sleep(float(5000) / 1000)
        wd.find_element_by_xpath("//div[@id='add-album']/div/div/a/img").click()
        wd.find_element_by_xpath("//main/nav[2]/a/img").click()
        if not ("TestSelenium" in wd.find_element_by_tag_name("html").text):
            success = False
            print("verifyTextPresent failed")
        wd.refresh()
        time.sleep(float(500) / 1000)
        if not ("TestSelenium" in wd.find_element_by_tag_name("html").text):
            success = False
            print("verifyTextPresent failed")
        self.assertTrue(success)

    def test_7deleteAlbum(self):
        success = True
        wd = self.wd
        wd.get("https://mra.nginxps.com/myphotos")
        wd.find_element_by_xpath("//div[@class='right-nav-btn']/a/img").click()
        wd.find_element_by_link_text("Delete Album").click()
        if not wd.find_element_by_xpath("//select[@id='delete-album-id']//option[2]").is_selected():
            wd.find_element_by_xpath("//select[@id='delete-album-id']//option[2]").click()
        wd.find_element_by_xpath("//form[@id='album-delete']//button[.='Delete Album']").click()
        time.sleep(float(500) / 1000)
        wd.find_element_by_xpath("//div[@id='delete-album']/div/div/a/img").click()
        wd.find_element_by_xpath("//main/nav[2]/a/img").click()
        if ("TestSelenium" in wd.find_element_by_tag_name("html").text):
            success = False
            print("not verifyTextPresent failed")
        wd.refresh()
        if ("TestSelenium" in wd.find_element_by_tag_name("html").text):
            success = False
            print("not verifyTextPresent failed")
        self.assertTrue(success)

    def tearDown(self):
        success = True

if __name__ == '__main__':
    unittest.main()
