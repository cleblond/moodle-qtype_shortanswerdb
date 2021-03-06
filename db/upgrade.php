<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Short-answer question type upgrade code.
 *
 * @package    qtype
 * @subpackage shortanswerdb
 * @copyright  2011 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();


/**
 * Upgrade code for the essay question type.
 * @param int $oldversion the version we are upgrading from.
 */
function xmldb_qtype_shortanswerdb_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    // Moodle v2.4.0 release upgrade line.
    // Put any upgrade step following this.

    if ($oldversion < 2013011799) {
        // Find duplicate rows before they break the 2013011803 step below.
        $problemids = $DB->get_recordset_sql("
                SELECT question, MIN(id) AS recordidtokeep
                  FROM {question_shortanswerdb}
              GROUP BY question
                HAVING COUNT(1) > 1
                ");
        foreach ($problemids as $problem) {
            $DB->delete_records_select('question_shortanswerdb',
                    'question = ? AND id > ?',
                    array($problem->question, $problem->recordidtokeep));
        }
        $problemids->close();

        // Shortanswer savepoint reached.
        upgrade_plugin_savepoint(true, 2013011799, 'qtype', 'shortanswerdb');
    }

    if ($oldversion < 2013011800) {

        // Define field answers to be dropped from question_shortanswerdb.
        $table = new xmldb_table('question_shortanswerdb');
        $field = new xmldb_field('answers');

        // Conditionally launch drop field answers.
        if ($dbman->field_exists($table, $field)) {
            $dbman->drop_field($table, $field);
        }

        // Shortanswer savepoint reached.
        upgrade_plugin_savepoint(true, 2013011800, 'qtype', 'shortanswerdb');
    }

    if ($oldversion < 2013011801) {

        // Define key question (foreign) to be dropped form question_shortanswerdb.
        $table = new xmldb_table('question_shortanswerdb');
        $key = new xmldb_key('question', XMLDB_KEY_FOREIGN, array('question'), 'question', array('id'));

        // Launch drop key question.
        $dbman->drop_key($table, $key);

        // Shortanswer savepoint reached.
        upgrade_plugin_savepoint(true, 2013011801, 'qtype', 'shortanswerdb');
    }

    if ($oldversion < 2013011802) {

        // Rename field question on table question_shortanswerdb to questionid.
        $table = new xmldb_table('question_shortanswerdb');
        $field = new xmldb_field('question', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'id');

        // Launch rename field question.
        $dbman->rename_field($table, $field, 'questionid');

        // Shortanswer savepoint reached.
        upgrade_plugin_savepoint(true, 2013011802, 'qtype', 'shortanswerdb');
    }

    if ($oldversion < 2013011803) {

        // Define key questionid (foreign-unique) to be added to question_shortanswerdb.
        $table = new xmldb_table('question_shortanswerdb');
        $key = new xmldb_key('questionid', XMLDB_KEY_FOREIGN_UNIQUE, array('questionid'), 'question', array('id'));

        // Launch add key questionid.
        $dbman->add_key($table, $key);

        // Shortanswer savepoint reached.
        upgrade_plugin_savepoint(true, 2013011803, 'qtype', 'shortanswerdb');
    }

    if ($oldversion < 2013011804) {

        // Define table qtype_shortanswerdb_options to be renamed to qtype_shortanswerdb_options.
        $table = new xmldb_table('question_shortanswerdb');

        // Launch rename table for qtype_shortanswerdb_options.
        $dbman->rename_table($table, 'qtype_shortanswerdb_options');

        // Shortanswer savepoint reached.
        upgrade_plugin_savepoint(true, 2013011804, 'qtype', 'shortanswerdb');
    }

    // Moodle v2.5.0 release upgrade line.
    // Put any upgrade step following this.


    // Moodle v2.6.0 release upgrade line.
    // Put any upgrade step following this.

    // Moodle v2.7.0 release upgrade line.
    // Put any upgrade step following this.

    // Moodle v2.8.0 release upgrade line.
    // Put any upgrade step following this.

    return true;
}
