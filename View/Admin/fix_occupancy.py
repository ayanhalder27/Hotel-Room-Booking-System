import sys

file_path = "c:\\xampp\\htdocs\\php\\Hotel-Room-Booking-System\\View\\Admin\\report-occupancy.js"

with open(file_path, "r", encoding="utf-8") as f:
    content = f.read()

# Replace escaped backticks and dollar signs
content = content.replace('\\`', '`')
content = content.replace('\\$', '$')

with open(file_path, "w", encoding="utf-8") as f:
    f.write(content)

print("Fixed")
