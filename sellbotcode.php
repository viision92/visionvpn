import telebot
from telebot import types

BOT_TOKEN = '6900629278:AAFWe7X6N5gWRyTHnnTnMrKBLOF0DOTng_g'
bot = telebot.TeleBot(BOT_TOKEN)

# Main Menu
main_menu_markup = types.ReplyKeyboardMarkup(resize_keyboard=True)
main_menu_markup.row(types.KeyboardButton('اکانت عمومی'), types.KeyboardButton('اکانت خصوصی'))

# Submenu for Public Account
public_menu_markup = types.ReplyKeyboardMarkup(resize_keyboard=True)
public_menu_markup.row(types.KeyboardButton('یکماهه حجم نامحدود'))
public_menu_markup.row(types.KeyboardButton('بازگشت به منوی اصلی'))

# Submenu for Private Account
private_menu_markup = types.ReplyKeyboardMarkup(resize_keyboard=True)
private_menu_markup.row(types.KeyboardButton('یک ماهه حجم نامحدود'))
private_menu_markup.row(types.KeyboardButton('سه ماهه حجم نامحدود 10% تخفیف'))
private_menu_markup.row(types.KeyboardButton('شش ماهه حجم نامحدود 12% تخفیف'))
private_menu_markup.row(types.KeyboardButton('یکساله حجم نامحدود 15% تخفیف'))
private_menu_markup.row(types.KeyboardButton('بازگشت به منوی اصلی'))

# Start Command
@bot.message_handler(commands=['start'])
def send_welcome(message):
    bot.send_message(message.chat.id, "به ربات ویژن خوش آمدید", reply_markup=main_menu_markup)

# Menu Handler
@bot.message_handler(func=lambda message: True)
def menu_handler(message):
    if message.text == 'اکانت عمومی':
        bot.send_message(message.chat.id, "گزینه‌های اکانت عمومی:", reply_markup=public_menu_markup)
    elif message.text == 'اکانت خصوصی':
        bot.send_message(message.chat.id, "گزینه‌های اکانت خصوصی:", reply_markup=private_menu_markup)
    elif message.text == 'یکماهه حجم نامحدود' or message.text == 'یک ماهه حجم نامحدود':
        bot.send_message(message.chat.id, "شماره کارت: [شماره کارت]\nمبلغ: [مبلغ مورد نظر]")
    elif message.text in ['سه ماهه حجم نامحدود 10% تخفیف', 'شش ماهه حجم نامحدود 12% تخفیف', 'یکساله حجم نامحدود 15% تخفیف']:
        bot.send_message(message.chat.id, "شماره کارت: [شماره کارت]\nمبلغ با تخفیف: [مبلغ مورد نظر]")
    elif message.text == 'بازگشت به منوی اصلی':
        bot.send_message(message.chat.id, "منوی اصلی", reply_markup=main_menu_markup)
    else:
        bot.send_message(message.chat.id, "لطفاً گزینه معتبری را از منو انتخاب کنید.")

# Polling
bot.polling(none_stop=True)
