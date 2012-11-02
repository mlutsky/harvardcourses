import xml.dom.minidom
import MySQLdb

dom = xml.dom.minidom.parse("/home/jharvard/vhosts/project0/courses.xml")

courses = dom.childNodes[0]

db = MySQLdb.connect(user="root", passwd="crimson", db="jharvard_project0")
c=db.cursor()

for course in dom.getElementsByTagName('course'):
    catNum = course.getAttributeNode("cat_num").nodeValue
    courseGroup = course.getElementsByTagName("course_group")[0].getAttributeNode("code").nodeValue
    courseNum = course.getElementsByTagName("course_number")[0].getElementsByTagName("num_int")[0].childNodes[0].nodeValue
    for courseNumChar in course.getElementsByTagName("course_number")[0].getElementsByTagName("num_char"):
        courseNum += courseNumChar.childNodes[0].nodeValue
    title = course.getElementsByTagName("title")[0].childNodes[0].nodeValue
    description = "";
    for desc in course.getElementsByTagName("description").childNodes:
        description += desc.nodeValue;
        
    #description = course.getElementsByTagName("description")[0].childNodes[0].nodeValue
    print catNum, courseGroup, courseNum, title

    #print """INSERT INTO `jharvard_project0`.`courses` (`id`, `catNum`, `courseGroup`, `courseNum`, `title`, `description`) VALUES (NULL, """ + catNum + ', "' + courseGroup + '", "' + courseNum + '", "' + title + '", "' + description + '");'
    #c.execute("""INSERT INTO `jharvard_project0`.`courses` (`id`, `catNum`, `courseGroup`, `courseNum`, `title`, `description`) VALUES (NULL, """ + '"' + catNum + '", "' + courseGroup + '", "' + courseNum + '", "' + title + '", "' + description + '");')
    c.execute("""INSERT INTO `jharvard_project0`.`courses` (`id`, `catNum`, `courseGroup`, `courseNum`, `title`, `description`) VALUES (NULL, %s, %s, %s, %s, %s);""", (catNum, courseGroup, courseNum, title, description))

    db.commit()
db.close()
