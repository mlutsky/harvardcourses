import MySQLdb
from BeautifulSoup import BeautifulStoneSoup

f = open("/home/jharvard/vhosts/project0/courses.xml", "r")
soup = BeautifulStoneSoup(f)

db = MySQLdb.connect(user="root", passwd="crimson", db="jharvard_project0")
c=db.cursor()

for course in soup.findAll('course'):
    if course['acad_year'] != '2012' and course.find('term')['spring_term'] != 'Y':
        print "not spring"
        continue

    catNum = course['cat_num']
    print catNum
    courseGroup = course.find('course_group')['code']
    if course.find('course_number').find('num_int'):
        courseNum = course.find('course_number').find('num_int').contents[0]
    if course.find('course_number').find('num_char'):
        courseNum += course.find('course_number').find('num_char').contents[0];
    title = course.find('title').contents[0]
    if course.find('description').contents:
        description = course.find('description').contents[0]
    #print catNum, courseGroup, courseNum, title, description

    c.execute("""INSERT INTO `jharvard_project0`.`courses` (`id`, `catNum`, `courseGroup`, `courseNum`, `title`, `description`) VALUES (NULL, %s, %s, %s, %s, %s);""", (catNum, courseGroup, courseNum, title, description))

    db.commit()
db.close()

f.close()
