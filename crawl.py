import requests
import time
from bs4 import BeautifulSoup
from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.chrome.options import Options
from webdriver_manager.chrome import ChromeDriverManager


# 소프트웨어까지
base_url = "https://www.sophia-it.com/word-category/%E3%82%BD%E3%83%95%E3%83%88%E3%82%A6%E3%82%A7%E3%82%A2"
term_dict = {}

# selenium set -------------------------------------------------------
# 웹 드라이버의 경로 지정 (다운로드한 웹 드라이버의 경로로 변경)
driver_path = ChromeDriverManager().install()

# 웹 드라이버 옵션 설정 (headless 모드로 실행)
options = webdriver.ChromeOptions()
options.add_argument('--headless')

# 웹 드라이버 생성
driver = webdriver.Chrome(options=options)


# 용어 카테고리 크롤링-------------------------------------------------
def crawling_category(url):

    response = requests.get(url)

    # 요청이 성공적으로 이루어졌는지 확인
    if response.status_code == 200:
        # HTML 문서를 파싱
        soup = BeautifulSoup(response.text, 'html.parser')

        # 클래스 이름을 사용하여 용어 목록 부분을 추출
        cat_list = soup.find('div', class_='wordCat')

        # 용어 목록이 있는지 확인
        if cat_list:
            # 각 용어와 뜻 추출하여 출력
            cats = cat_list.find_all('li')
            cat_all = []
            for cat in cats:
                cat_all.append(cat.find('a').text) 
            return cat_all     
        else:
            print("cat 목록을 찾을 수 없습니다.")
        
    else:
        print("사이트에 접속할 수 없습니다.")   

        
# 카테고리 내 용어 크롤링---------------------------------------------------------
def crawling_word(ctg):
    term_dict = {}
    for i in ctg:
        url = f"https://www.sophia-it.com/word-category/ソフトウェア/{i}"
        response = requests.get(url)

        # 요청이 성공적으로 이루어졌는지 확인
        if response.status_code == 200:
            # HTML 문서를 파싱
            soup = BeautifulSoup(response.text, 'html.parser')

            # 클래스 이름을 사용하여 용어 목록 부분을 추출
            word_list = soup.find('div', class_='wordList')
            word_cat = soup.find('div', class_='wordCat')

            # 용어 목록이 있는지 확인
            if word_list:
                # 용어만 추출
                words = word_list.find_all('a')
                l = []
                for word in words:
                    l.append(word.string)  
                term_dict[i] = l
                    
            else:
                print("word 목록을 찾을 수 없습니다.")

        else:
            print("사이트에 접속할 수 없습니다.")   
            
    return term_dict
        

# 용어 정의 크롤링---------------------------------------------------
def crawling_meaning(word):
    url = f"https://www.sophia-it.com/content/{word}"
    response = requests.get(url)

    # 요청이 성공적으로 이루어졌는지 확인
    if response.status_code == 200:
        # HTML 문서를 파싱
        soup = BeautifulSoup(response.text, 'html.parser')

        # 클래스 이름을 사용하여 용어 설명 부분을 추출
        meaning = soup.find('td', class_='txts').p.text

        # 용어 설명이 있는지 확인 및 출력
        if meaning:
            return(meaning)
        else:
            print("mean을 찾을 수 없습니다.")
        
    else:
        print("사이트에 접속할 수 없습니다.")  
        
        
# 일-한 번역 결과 크롤링-------------------------------------------------
def crawling_translate(jap):
    url = f"https://papago.naver.com/?sk=ja&tk=ko&hn=0&st={jap}"
    
    driver.get(url)
    
    # 번역 결과가 나타날 때까지 대기. (명시적 대기)
    css_selector = "#txtTarget"
    WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.CSS_SELECTOR, css_selector)))

    # 번역 결과를 가져와 출력.
    kor = driver.find_element(By.CSS_SELECTOR, css_selector).text 
    
    return kor
    
    driver.quit()      
                   

# (단어 뜻, 정의 번역 실행 예시 및 실행 시간 측정) ---------------------------------

w = "オペレーティングシステム"
m = crawling_meaning(w)
start_time = time.time()
print(w)
print(crawling_translate(w))
print(crawling_translate(m))
end_time = time.time()
execution_time = end_time - start_time
print(f"실행 시간: {execution_time:.6f}초")


# 김씨가 저번에 말한 단어만 리스트로 추출
l = crawling_category(base_url)
l = [l[0],l[6],l[8]]
l

# 해당 태그들을 key로, 하위 단어들의 리스트를 value로 갖는 딕셔너리 생성
crawling_word(l)


# 사용자가 페이지에서 보여지는 단어 중 "Chrome OS"를 선택한 상황을 가정
user_word = "Chrome OS"
m = crawling_meaning(user_word)
print("설명: "+m)
print("번역: "+crawling_translate(m))