#!/usr/bin/env python
# coding: utf-8

# In[25]:


#first get webdriver, chromedriver and time
import time
from selenium import webdriver #pip install selenium
from webdriver_manager.chrome import ChromeDriverManager #pip intall webdriver-manager


# In[26]:


#customer login function
def customer_login():
    #direct driver to site
    driver.get('http://localhost/CSSDProjectExtention/')
    time.sleep(2) 
    #select login
    login = driver.find_element_by_link_text("LOG IN")
    login.click()
    time.sleep(2) 
    username = driver.find_element_by_name('username')
    username.send_keys("123")
    password = driver.find_element_by_name('password')
    password.send_keys("123")
    time.sleep(1)
    password.submit()
    #give a second to login
    time.sleep(1)


# In[27]:


#admin login function
def admin_login():
    #direct driver to site
    driver.get('http://localhost/CSSDProjectExtention/')
    time.sleep(2)
    #select login
    login = driver.find_element_by_link_text("LOG IN")
    login.click()
    time.sleep(2) # Let the user actually see something!
    username = driver.find_element_by_name('username')
    username.send_keys("admin")
    password = driver.find_element_by_name('password')
    password.send_keys("admin")
    time.sleep(1)
    password.submit()
    #give a second to login
    time.sleep(1)


# # Create purchase order

# In[28]:


from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.common.keys import Keys
driver = webdriver.Chrome(ChromeDriverManager().install())
 #direct driver to site
driver.set_window_size(1500, 1000)
customer_login()

order = driver.find_element_by_link_text("ORDER ITEMS")
order.click()
item1 = driver.find_element_by_name('0')
item1.send_keys("2.0")
item2 = driver.find_element_by_name('3')
item2.send_keys("1.0")
address = driver.find_element_by_name('address')
address.send_keys("1 test road")
location = driver.find_element_by_name('location')
location.click()
location.send_keys(Keys.DOWN,Keys.RETURN)

#js total calculation
actual_1 = driver.find_element_by_class_name('total').text
expected_1 = "£120"

submit = driver.find_element_by_class_name('btn-success')
submit.click()
#submit result
actual_2 = driver.find_element_by_class_name('result').text
expected_2 = "Your order request has been submitted. We aim to respond within 24 hours. Check the progress on your dashboard."

if(actual_1 == expected_1 and actual_2 == expected_2):
    print("Test passed")
else:
    print("Test failed")
print("Expected_1: "+ expected_1)
print("Actual_1: "+ actual_1)
print("Expected_2: "+ expected_2)
print("Actual_2: "+ actual_2)
driver.quit()


# # Delete purchase order

# In[31]:


#the prerequisite for this test is that the top order has not been responded to
driver = webdriver.Chrome(ChromeDriverManager().install())
 #direct driver to site
driver.set_window_size(1500, 1000)
customer_login()
cancel = driver.find_element_by_name('cancel')
cancel.click()
expected = "Your order request has been successfully cancelled."
actual = driver.find_element_by_class_name('result').text
if(actual == expected):
    print("Test passed")
else:
    print("Test failed")
print("Expected: "+ expected)
print("Actual: "+ actual)
driver.quit()


# # Respond to order

# In[32]:


#the prerequisite for this test is that there his an active order request
driver = webdriver.Chrome(ChromeDriverManager().install())
 #direct driver to site
driver.set_window_size(1500, 1000)
admin_login()
view = driver.find_element_by_name('viewOrder')
view.click()
#wait to load next page
time.sleep(1)
submit = driver.find_element_by_name('submit')
submit.click()
time.sleep(1)
expected = "Order Accepted"
actual = driver.find_element_by_name('orderStatus').text
if(actual == expected):
    print("Test passed")
else:
    print("Test failed")
print("Expected: "+ expected)
print("Actual: "+ actual)
driver.quit()


# # Amend purchase order

# In[33]:


driver = webdriver.Chrome(ChromeDriverManager().install())
 #direct driver to site
driver.set_window_size(1500, 1000)
admin_login()
view = driver.find_element_by_name('viewOrder')
view.click()
#wait to load next page
time.sleep(1)
remove = driver.find_element_by_name('remove')
remove.click()
expected = 'Item removed from order.'
actual = driver.find_element_by_class_name('result').text
if(actual == expected):
    print("Test passed")
else:
    print("Test failed")
print("Expected: "+ expected)
print("Actual: "+ actual)
driver.quit()


# 

# In[ ]:




